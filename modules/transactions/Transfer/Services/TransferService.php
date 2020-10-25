<?php

namespace Transactions\Transfer\Services;

use Customers\Contracts\CustomerRepositoryInterface;
use Customers\Models\Customer;
use Transactions\Connections\Gateway\GatewayConnection;
use Transactions\Contracts\TransactionRepositoryInterface;
use Transactions\Contracts\TransactionServiceInterface as TransactionInterface;
use Transactions\Models\Transaction;
use Transactions\Transfer\Contracts\TransferServiceInterface as ServiceInterface;
use Transactions\Transfer\Exceptions\TransferExceptions;
use Transactions\Transfer\Helpers\TransferMapper;
use Transactions\Transfer\Jobs\TransferJob;
use Wallets\Contracts\WalletServiceInterface;

class TransferService implements ServiceInterface, TransactionInterface
{
    protected $walletService;
    protected $customerRepository;
    protected $transactionRepository;
    protected $gatewayConnection;

    public function __construct(
        GatewayConnection $gatewayConnection,
        WalletServiceInterface $walletService,
        CustomerRepositoryInterface $customerRepository,
        TransactionRepositoryInterface $transactionRepository
    ){
        $this->walletService = $walletService;
        $this->gatewayConnection = $gatewayConnection;
        $this->customerRepository = $customerRepository;
        $this->transactionRepository = $transactionRepository;
    }

    public function new(TransferMapper $data): Transaction
    {
        $this->hasBalanceOrBreak($data->getPayer(), $data->getValue());

        $transaction = Transaction::first();//$this->transactionRepository->create($data->mapToTransaction());

        TransferJob::dispatchNow($transaction);

        return $transaction;
    }

    public function submit(Transaction $transaction)
    {
        $this->debit($transaction);
        $this->authorize($transaction);

        dd($transaction);
    }

    private function debit(Transaction $transaction): void
    {
        $payer = $transaction->payer;
        $value = $transaction->value;

        $this->hasBalanceOrBreak($payer, $value);

        $this->walletService->debit($payer, $value);
    }

    private function authorize(Transaction $transaction): void
    {
        $isAuthorized = $this->gatewayConnection->transferIsAuthorized($transaction);
        throw_unless($isAuthorized, TransferExceptions::unauthorized());
    }

    private function hasBalanceOrBreak(Customer $customer, float $value): void
    {
        $hasBalance = $this->walletService->hasAvailableBalance($customer, $value);
        throw_unless($hasBalance, TransferExceptions::insufficientFunds());
    }
}

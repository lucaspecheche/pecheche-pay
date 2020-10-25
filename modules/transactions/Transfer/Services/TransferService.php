<?php

namespace Transactions\Transfer\Services;

use Customers\Contracts\CustomerRepositoryInterface;
use Customers\Models\Customer;
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

    public function __construct(
        WalletServiceInterface $walletService,
        CustomerRepositoryInterface $customerRepository,
        TransactionRepositoryInterface $transactionRepository
    ){
        $this->walletService         = $walletService;
        $this->customerRepository    = $customerRepository;
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

        dd($transaction);
    }

    private function debit(Transaction $transaction): void
    {
        $payer = $transaction->payer;
        $value = $transaction->value;

        $this->hasBalanceOrBreak($payer, $value);

        $this->walletService->debit($payer, $value);
    }

    private function hasBalanceOrBreak(Customer $customer, float $value): void
    {
        $hasBalance = $this->walletService->hasAvailableBalance($customer, $value);
        throw_unless($hasBalance, TransferExceptions::insufficientFunds());
    }
}

<?php

namespace Transactions\Transfer\Services;

use Customers\Contracts\CustomerRepositoryInterface;
use Customers\Models\Customer;
use Transactions\Connections\Gateway\GatewayConnection;
use Transactions\Constants\Status;
use Transactions\Contracts\TransactionRepositoryInterface;
use Transactions\Contracts\TransactionServiceInterface as TransactionInterface;
use Transactions\Models\Transaction;
use Transactions\Transfer\Contracts\TransferServiceInterface as ServiceInterface;
use Transactions\Transfer\Events\TransferCompleted;
use Transactions\Transfer\Exceptions\TransferExceptions;
use Transactions\Transfer\Helpers\TransferMapper;
use Transactions\Transfer\Jobs\TransferJob;
use Wallets\Contracts\WalletServiceInterface;

class TransferService implements ServiceInterface, TransactionInterface
{
    /** @var Transaction */
    protected $transaction;

    protected $walletService;
    protected $customerRepository;
    protected $transactionRepository;
    protected $gatewayConnection;

    public function __construct(
        GatewayConnection $gatewayConnection,
        WalletServiceInterface $walletService,
        CustomerRepositoryInterface $customerRepository,
        TransactionRepositoryInterface $transactionRepository
    ) {
        $this->walletService         = $walletService;
        $this->gatewayConnection     = $gatewayConnection;
        $this->customerRepository    = $customerRepository;
        $this->transactionRepository = $transactionRepository;
    }

    public function new(TransferMapper $data): Transaction
    {
        $this->hasAvailableBalance($data->getPayer(), $data->getValue());

        $transaction = $this->transactionRepository->create($data->mapToTransaction());

        $this->useAsyncTransaction()
            ? TransferJob::dispatch($transaction)
            : TransferJob::dispatchNow($transaction);

        return $transaction;
    }

    public function submit(Transaction $transaction): void
    {
        $this->transaction = $transaction;

        try {
            $this->validate()
                ->authorize()
                ->debit()
                ->credit()
                ->success();
        } catch (\Exception $exception) {
            $this->refund();
            throw $exception;
        }
    }

    private function debit(): TransferService
    {
        $this->walletService->debit(
            $this->transaction->payer,
            $this->transaction->value
        );

        $this->transaction->updateStatus(Status::DEBITED);

        return $this;
    }

    private function credit(): TransferService
    {
        $this->walletService->credit(
            $this->transaction->payee,
            $this->transaction->value
        );

        $this->transaction->updateStatus(Status::CREDITED);

        return $this;
    }

    private function refund(): TransferService
    {
        if ($this->transaction->isDebited()) {
            $this->walletService->refund(
                $this->transaction->payer,
                $this->transaction->value
            );

            $this->transaction->updateStatus(Status::REFUNDED);
        }

        return $this;
    }

    private function validate(): TransferService
    {
        $this->hasAvailableBalance(
            $this->transaction->payer,
            $this->transaction->value
        );

        return $this;
    }

    private function authorize(): TransferService
    {
        $isAuthorized = $this->gatewayConnection->transferIsAuthorized($this->transaction);
        throw_unless($isAuthorized, TransferExceptions::unauthorized());

        return $this;
    }

    protected function success(): TransferService
    {
        $this->transaction->updateStatus(Status::COMPLETED);
        TransferCompleted::dispatch($this->transaction);

        return $this;
    }

    protected function hasAvailableBalance(Customer $customer, float $value): TransferService
    {
        $hasBalance = $this->walletService->hasAvailableBalance($customer, $value);
        throw_unless($hasBalance, TransferExceptions::insufficientFunds());

        return $this;
    }

    private function useAsyncTransaction(): bool
    {
        return config('transaction.async');
    }
}

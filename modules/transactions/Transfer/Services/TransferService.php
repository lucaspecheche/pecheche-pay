<?php

namespace Transactions\Transfer\Services;

use Customers\Contracts\CustomerRepositoryInterface;
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

    public function new(TransferMapper $data)
    {
        if ($this->walletService->hasAvailableBalance($data->getPayer(), $data->getValue())) {
            $transaction = $this->transactionRepository->create($data->mapToTransaction());
            $this->submit($transaction);

            return $transaction;
        }

        throw TransferExceptions::balanceUnavailable();
    }

    public function submit(Transaction $transaction)
    {
        TransferJob::dispatch($transaction);
    }
}

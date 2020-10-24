<?php

namespace Transactions\Services;

use Customers\Contracts\CustomerRepositoryInterface;
use Transactions\Contracts\TransactionServiceInterface as ServiceInterface;
use Transactions\Exceptions\TransactionExceptions;
use Transactions\Helpers\Data\NewTransactionData;
use Wallets\Contracts\WalletServiceInterface;

class TransactionService implements ServiceInterface
{
    protected $walletService;
    protected $customerRepository;

    public function __construct(
        WalletServiceInterface $walletService,
        CustomerRepositoryInterface $customerRepository
    ){
        $this->walletService      = $walletService;
        $this->customerRepository = $customerRepository;
    }

    public function new(NewTransactionData $data)
    {
        if ($this->walletService->hasAvailableBalance($data->getPayer(), $data->getValue())) {
            dd('Dispatch');
        }

        throw TransactionExceptions::balanceUnavailable();
    }
}

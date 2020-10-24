<?php

namespace Transactions\Helpers\Data;

use Customers\Contracts\CustomerRepositoryInterface;
use Customers\Models\Customer;

class NewTransactionData
{
    protected $customerRepository;

    private $payer;
    private $payee;
    private $value;

    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function setAll(array $attributes): NewTransactionData
    {
        $this->payer = $this->customerRepository->getById(data_get($attributes, 'payer'));
        $this->payee = $this->customerRepository->getById(data_get($attributes, 'payee'));
        $this->value = data_get($attributes, 'value');

        return $this;
    }

    public function isValid(): bool
    {
        return $this->getPayer() && $this->getPayee() && $this->getValue();
    }

    public function getPayer(): Customer
    {
        return $this->payer;
    }

    public function getPayee(): Customer
    {
        return $this->payee;
    }

    public function getValue(): float
    {
        return $this->value;
    }
}

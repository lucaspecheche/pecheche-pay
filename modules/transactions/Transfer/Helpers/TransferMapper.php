<?php

namespace Transactions\Transfer\Helpers;

use Customers\Contracts\CustomerRepositoryInterface;
use Customers\Models\Customer;
use Transactions\Constants\Status;
use Transactions\Constants\Types;

class TransferMapper
{
    protected $customerRepository;

    private $payer;
    private $payee;
    private $value;

    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function setAll(array $attributes): TransferMapper
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

    public function toArray()
    {
        return [

        ];
    }

    public function mapToTransaction(): array
    {
        return [
            'value'    => $this->value,
            'payer_id' => $this->getPayer()->id,
            'payee_id' => $this->getPayee()->id,
            'status'   => Status::PENDING_SUBMISSION,
            'type'     => Types::TRANSFER
        ];
    }
}

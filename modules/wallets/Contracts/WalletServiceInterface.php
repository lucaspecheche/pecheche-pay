<?php

namespace Wallets\Contracts;

use Customers\Models\Customer;

interface WalletServiceInterface
{
    public function hasAvailableBalance(Customer $customer, float $value): bool;

    public function debit(Customer $customer, float $value): void;

    public function credit(Customer $customer, float $value): void;
}

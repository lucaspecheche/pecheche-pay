<?php

namespace Wallets\Contracts;

use Customers\Models\Customer;

interface WalletServiceInterface
{
    public function hasBalanceAvailable(Customer $customer, float $value): bool;
}

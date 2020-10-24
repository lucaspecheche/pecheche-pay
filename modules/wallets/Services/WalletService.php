<?php

namespace Wallets\Services;

use Customers\Models\Customer;
use Wallets\Contracts\WalletServiceInterface;

class WalletService implements WalletServiceInterface
{
    public function hasAvailableBalance(Customer $customer, float $value): bool
    {
        return $customer->wallet->getAvailableBalance() >= $value;
    }
}

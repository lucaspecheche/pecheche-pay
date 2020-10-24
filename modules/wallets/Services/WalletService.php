<?php

namespace Wallets\Services;

use Customers\Models\Customer;
use Wallets\Contracts\WalletServiceInterface;

class WalletService implements WalletServiceInterface
{
    public function hasBalanceAvailable(Customer $customer, float $value): bool
    {
        dd($customer->wallet);
    }
}

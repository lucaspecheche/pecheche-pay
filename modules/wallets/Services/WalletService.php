<?php

namespace Wallets\Services;

use Customers\Models\Customer;
use Wallets\Contracts\WalletServiceInterface;
use Wallets\Exceptions\WalletExceptions;

class WalletService implements WalletServiceInterface
{
    public function hasAvailableBalance(Customer $customer, float $value): bool
    {
        return $customer->wallet->getBalance() >= $value;
    }

    public function debit(Customer $customer, float $value): void
    {
        $currentBalance = $customer->wallet->getBalance();
        $newBalance     = $currentBalance - $value;

        $result = $customer->wallet->update(['balance' => $newBalance], ['touch' => true]);
        throw_unless($result, WalletExceptions::debitError());
    }
}

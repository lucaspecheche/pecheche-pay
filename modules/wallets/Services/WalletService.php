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
        $newBalance = $customer->wallet->getBalance() - $value;
        throw_unless($this->updateBalance($customer, $newBalance), WalletExceptions::debitError());
    }

    public function credit(Customer $customer, float $value): void
    {
        $newBalance = $customer->wallet->getBalance() + $value;
        throw_unless($this->updateBalance($customer, $newBalance), WalletExceptions::creditError());
    }

    public function refund(Customer $customer, float $value): void
    {
        $this->credit($customer, $value);
    }

    private function updateBalance(Customer $customer, $newBalance): bool
    {
        return $customer->wallet->update(['balance' => $newBalance], ['touch' => true]);
    }
}

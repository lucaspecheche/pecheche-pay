<?php


namespace Transactions\Database\Factories;

use Customers\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Transactions\Models\Transaction;
use Wallets\Database\Factories\WalletFactory;

class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition(): array
    {
        return [
            'value' => $this->faker->randomFloat(2, 0, 1000),
        ];
    }

    public function withUser(): TransactionFactory
    {
        return $this->state(function() {
            return [
                'customer_id' => Customer::factory()->withUser()->create()
            ];
        });
    }

    public function withMerchant(): TransactionFactory
    {
        return $this->state(function() {
            return [
                'customer_id' => Customer::factory()->withMerchant()->create()
            ];
        });
    }
}

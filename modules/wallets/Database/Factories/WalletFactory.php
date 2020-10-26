<?php

namespace Wallets\Database\Factories;

use Customers\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Wallets\Models\Wallet;

class WalletFactory extends Factory
{
    protected $model = Wallet::class;

    public function definition(): array
    {
        return [
            'balance' => $this->faker->randomFloat(2, 0, 1000),
            'customer_id' => Customer::factory()->withUser()->create()
        ];
    }

    public function withUser(): WalletFactory
    {
        return $this->state(function () {
            return [
                'customer_id' => Customer::factory()->withUser()->create()
            ];
        });
    }

    public function withMerchant(): WalletFactory
    {
        return $this->state(function () {
            return [
                'customer_id' => Customer::factory()->withMerchant()->create()
            ];
        });
    }
}

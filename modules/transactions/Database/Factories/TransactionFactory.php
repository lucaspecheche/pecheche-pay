<?php


namespace Transactions\Database\Factories;

use Customers\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Transactions\Constants\Status;
use Transactions\Constants\Types;
use Transactions\Models\Transaction;
use Wallets\Database\Factories\WalletFactory;

class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition(): array
    {
        return [
            'value' => $this->faker->randomFloat(2, 0, 1000),
            'type' => Types::TRANSFER,
            'status' => Status::CREATED
        ];
    }

    public function withPayer(Customer $payer): TransactionFactory
    {
        return $this->state(function () use ($payer) {
            return [
                'payer_id' => $payer->id
            ];
        });
    }

    public function withPayee(Customer $payee): TransactionFactory
    {
        return $this->state(function () use ($payee) {
            return [
                'payee_id' => $payee->id
            ];
        });
    }
}

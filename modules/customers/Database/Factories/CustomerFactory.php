<?php

namespace Customers\Database\Factories;

use Customers\Models\Customer;
use Customers\Models\Merchant;
use Customers\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    public function definition(): array
    {
        return $this->mapper(User::factory()->create());
    }

    public function withUser(): CustomerFactory
    {
        return $this->withType(User::factory()->create());
    }

    public function withMerchant(): CustomerFactory
    {
        return $this->withType(Merchant::factory()->create());
    }

    private function withType(Model $model): CustomerFactory
    {
        $mapper = $this->mapper($model);

        return $this->state(function () use ($mapper) {
            return $mapper;
        });
    }

    private function mapper(Model $model): array
    {
        return [
            'customerable_type' => get_class($model),
            'customerable_id' => $model->id
        ];
    }
}

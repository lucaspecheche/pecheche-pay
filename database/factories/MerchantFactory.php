<?php

namespace Database\Factories;

use App\Models\Merchant;

class MerchantFactory extends UserFactory
{
    protected $model = Merchant::class;

    protected function generateUID(): int
    {
        return $this->faker->unique()->numberBetween(10000, 20000);
    }
}

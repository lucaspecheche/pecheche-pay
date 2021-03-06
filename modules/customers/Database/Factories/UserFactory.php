<?php

namespace Customers\Database\Factories;

use Customers\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'cpf' => $this->faker->unique()->cpf(false),
            'password' => $this->faker->unique()->password
        ];
    }
}

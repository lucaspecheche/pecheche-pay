<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'uid' => $this->generateUID(),
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'cpf' => $this->faker->unique()->cpf(false),
            'password' => $this->faker->unique()->password
        ];
    }

    protected function generateUID(): int
    {
        return $this->faker->unique()->numberBetween(1000, 9999);
    }
}

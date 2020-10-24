<?php

namespace Customers\Database\Seeders;

use Customers\Models\Customer;
use Customers\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::factory()->times(10)->create();

        $users->each(static function(User $user) {
            $user->customer()->save(new Customer());
        });

    }
}

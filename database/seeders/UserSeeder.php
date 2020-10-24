<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\User;
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

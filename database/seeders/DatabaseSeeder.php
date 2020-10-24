<?php

namespace Database\Seeders;

use Customers\Database\Seeders\CustomerSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
         $this->call([
             CustomerSeeder::class
         ]);
    }
}

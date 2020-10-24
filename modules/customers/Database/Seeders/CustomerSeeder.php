<?php

namespace Customers\Database\Seeders;

use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
         $this->call([
             UserSeeder::class,
             MerchantSeeder::class
         ]);
    }
}

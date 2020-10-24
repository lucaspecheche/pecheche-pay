<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Wallets\Models\Wallet;

class InitialDataSeeder extends Seeder
{
    public function run(): void
    {
        Wallet::factory()->times(5)->withUser()->create();
        Wallet::factory()->times(5)->withMerchant()->create();
    }
}

<?php

namespace Customers\Database\Seeders;

use Customers\Models\Customer;
use Customers\Models\Merchant;
use Illuminate\Database\Seeder;

class MerchantSeeder extends Seeder
{
    public function run(): void
    {
        $merchants = Merchant::factory()->times(10)->create();

        $merchants->each(static function(Merchant $merchant) {
            $merchant->customer()->save(new Customer());
        });
    }
}

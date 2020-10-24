<?php

namespace App\Providers;

use Customers\Providers\CustomerServiceProvider;
use Illuminate\Support\ServiceProvider;
use Transactions\Providers\TransactionProvider;
use Wallets\Providers\WalletServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(TransactionProvider::class);
        $this->app->register(CustomerServiceProvider::class);
        $this->app->register(WalletServiceProvider::class);
    }
}

<?php

namespace App\Providers;

use Customers\Providers\CustomerServiceProvider;
use Illuminate\Support\ServiceProvider;
use Transactions\Providers\TransactionServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(TransactionServiceProvider::class);
        $this->app->register(CustomerServiceProvider::class);
    }
}

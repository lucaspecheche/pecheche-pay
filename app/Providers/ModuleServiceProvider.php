<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Transactions\Providers\TransactionServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(TransactionServiceProvider::class);
    }
}

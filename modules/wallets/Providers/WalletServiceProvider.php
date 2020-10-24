<?php

namespace Wallets\Providers;

use Illuminate\Support\ServiceProvider;
use Wallets\Contracts\WalletServiceInterface;
use Wallets\Services\WalletService;

class WalletServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(WalletServiceInterface::class, WalletService::class);
    }

    public function boot(): void
    {
        $this->registerMigrations();
    }

    public function registerMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }
}

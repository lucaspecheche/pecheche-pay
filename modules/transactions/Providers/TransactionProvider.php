<?php

namespace Transactions\Providers;

use Illuminate\Support\ServiceProvider;
use Transactions\Contracts\TransactionServiceInterface;
use Transactions\Services\TransactionService;

class TransactionProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(TransactionServiceInterface::class, TransactionService::class);
    }

    public function boot(): void
    {
        $this->registerApiRoutes();
        $this->registerMigrations();
    }

    public function registerMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    public function registerApiRoutes(): void
    {
        $this->app->router->group(['prefix' => 'transactions'], static function ($router) {
            require_once __DIR__ . '/../Routes/api.php';
        });
    }
}

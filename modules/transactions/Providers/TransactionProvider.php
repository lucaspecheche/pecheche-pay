<?php

namespace Transactions\Providers;

use Illuminate\Support\ServiceProvider;
use Transactions\Contracts\TransactionRepositoryInterface;
use Transactions\Repositories\TransactionRepository;
use Transactions\Transfer\Contracts\TransferServiceInterface;
use Transactions\Transfer\Services\TransferService;

class TransactionProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerConfig();
        $this->bindInterfaces();

        $this->app->register(TransactionEventProvider::class);
        $this->app->register(TransactionConnectionsProvider::class);
    }

    public function boot(): void
    {
        $this->registerApiRoutes();
        $this->registerMigrations();
        $this->registerTranslations();
    }

    protected function registerConfig(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../Configs/transaction.php', 'transaction');
    }

    public function registerTranslations(): void
    {
        $this->loadTranslationsFrom(__DIR__ . '/../Translations', 'transaction');
    }

    public function registerMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    public function registerApiRoutes(): void
    {
        $this->app->router->group(['prefix' => 'v1/transactions'], static function ($router) {
            require __DIR__ . '/../Routes/api.php';
        });
    }

    private function bindInterfaces(): void
    {
        $this->app->bind(TransferServiceInterface::class, TransferService::class);
        $this->app->bind(TransactionRepositoryInterface::class, TransactionRepository::class);
    }
}

<?php

namespace Transactions\Providers;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use Transactions\Connections\Gateway\GatewayClient;
use Transactions\Contracts\TransactionRepositoryInterface;
use Transactions\Repositories\TransactionRepository;
use Transactions\Transfer\Contracts\TransferServiceInterface;
use Transactions\Transfer\Services\TransferService;

class TransactionProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerGatewayClient();
        $this->app->bind(TransferServiceInterface::class, TransferService::class);
        $this->app->bind(TransactionRepositoryInterface::class, TransactionRepository::class);
    }

    public function boot(): void
    {
        $this->registerApiRoutes();
        $this->registerMigrations();
        $this->registerTranslations();
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
            require_once __DIR__ . '/../Routes/api.php';
        });
    }

    private function registerGatewayClient(): void
    {
        $this->app->singleton(GatewayClient::class, static function() {
            $guzzleClient = new Client(['base_uri' => env('GATEWAY_API_URI')]);

            return new GatewayClient($guzzleClient);
        });
    }
}

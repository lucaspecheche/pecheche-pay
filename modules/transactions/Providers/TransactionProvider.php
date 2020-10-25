<?php

namespace Transactions\Providers;

use App\Connections\Http\RestClient;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use Transactions\Connections\Gateway\GatewayClient;
use Transactions\Connections\Gateway\GatewayClientInterface;
use Transactions\Connections\Inform\InformClient;
use Transactions\Connections\Inform\InformClientInterface;
use Transactions\Contracts\TransactionRepositoryInterface;
use Transactions\Repositories\TransactionRepository;
use Transactions\Transfer\Contracts\TransferServiceInterface;
use Transactions\Transfer\Services\TransferService;

class TransactionProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerGatewayClient();
        $this->registerInformClient();
        $this->bindInterfaces();

        $this->app->register(TransactionEventProvider::class);
    }

    public function boot(): void
    {
        $this->registerConfig();
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

    private function registerGatewayClient(): void
    {
        $this->app->singleton(GatewayClientInterface::class, static function() {
            $guzzleClient = new Client(['base_uri' => env('GATEWAY_API_URI')]);

            return new GatewayClient($guzzleClient);
        });
    }

    private function registerInformClient(): void
    {
        $this->app->singleton(InformClientInterface::class, static function() {
            $guzzleClient = new Client(['base_uri' => env('INFORM_API_URI')]);

            return new InformClient($guzzleClient);
        });
    }
}

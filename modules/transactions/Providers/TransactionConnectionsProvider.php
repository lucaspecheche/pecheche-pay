<?php

namespace Transactions\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;
use Transactions\Connections\Gateway\GatewayConnection;
use Transactions\Connections\Inform\InformConnection;
use Transactions\Tests\Mocks\GatewayMock;
use Transactions\Tests\Mocks\InformMock;

class TransactionConnectionsProvider extends ServiceProvider
{
    private const ENVIRONMENT = 'testing';

    public function register(): void
    {
        $this->registerGatewayClient();
        $this->registerInformClient();
    }

    private function registerGatewayClient(): void
    {
        $this->app->singleton(GatewayConnection::class, static function() {
            $httpClient = self::isTesting()
                ? GatewayMock::make()
                : Http::baseUrl(config('transaction.gateway.baseUri'));

            return new GatewayConnection($httpClient);
        });
    }

    private function registerInformClient(): void
    {
        $this->app->singleton(InformConnection::class, static function() {
            $httpClient = self::isTesting()
                ? InformMock::make()
                : Http::baseUrl(config('transaction.inform.baseUri'));

            return new InformConnection($httpClient);
        });
    }

    private static function isTesting(): bool
    {
        return App::environment(self::ENVIRONMENT);
    }
}

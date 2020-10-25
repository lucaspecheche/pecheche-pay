<?php

namespace Transactions\Tests\Mocks;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Transactions\Connections\Gateway\GatewayRoutes;

class GatewayMock
{
    public static function make(): PendingRequest
    {
        return Http::fake([
            '*' => self::default(),
            GatewayRoutes::authorizeTransfer('*') => self::authorizeTransfer(),
        ])->acceptJson();
    }

    private static function authorizeTransfer(): PromiseInterface
    {
        return Http::response([
            'message' => 'Autorizado'
        ], Response::HTTP_OK);
    }

    private static function default(): PromiseInterface
    {
        return Http::response([
            'message' => 'Not Found'
        ], Response::HTTP_NOT_FOUND);
    }
}

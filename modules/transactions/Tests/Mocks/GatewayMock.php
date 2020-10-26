<?php

namespace Transactions\Tests\Mocks;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Transactions\Connections\Gateway\GatewayRoutes;

class GatewayMock
{
    public const TRANSACTION_ID_ERROR = 99999;

    public static function make(): PendingRequest
    {
        return Http::fake([
            GatewayRoutes::authorizeTransfer('*') => self::authorizeTransfer(),
            '*' => self::error()
        ])->acceptJson();
    }

    private static function authorizeTransfer(): callable
    {
        return static function (Request $request) {
            $transactionId = data_get($request->data(), 'id');

            return $transactionId === self::TRANSACTION_ID_ERROR
                ? self::error()
                : self::success();
        };
    }

    private static function error(): PromiseInterface
    {
        return Http::response([
            'message' => 'Not Found'
        ], Response::HTTP_NOT_FOUND);
    }

    private static function success(): PromiseInterface
    {
        return Http::response([
            'message' => 'Autorizado'
        ], Response::HTTP_OK);
    }
}

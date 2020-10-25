<?php

namespace Transactions\Tests\Mocks;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Transactions\Connections\Inform\InformRoutes;

class InformMock
{
    public static function make(): PendingRequest
    {
        return Http::fake([
            '*' => self::default(),
            InformRoutes::sendMsg('*') => self::sendMsg(),
        ])->acceptJson();
    }

    private static function sendMsg(): PromiseInterface
    {
        return Http::response([
            'message' => 'Enviado'
        ], Response::HTTP_OK);
    }

    private static function default(): PromiseInterface
    {
        return Http::response([
            'message' => 'Not Found'
        ], Response::HTTP_NOT_FOUND);
    }
}

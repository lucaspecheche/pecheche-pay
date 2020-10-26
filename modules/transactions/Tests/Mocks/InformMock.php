<?php

namespace Transactions\Tests\Mocks;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Response;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Transactions\Connections\Inform\InformRoutes;

class InformMock
{
    public const INFORM_MESSAGE_ERROR = 'send-error';

    public static function make(): PendingRequest
    {
        return Http::fake([
            InformRoutes::sendMsg('*') => self::sendMsg(),
            '*' => self::error()
        ])->acceptJson();
    }

    private static function sendMsg(): callable
    {
        return static function (Request $request) {
            $message = data_get($request->data(), 'message');

            return $message === self::INFORM_MESSAGE_ERROR
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
            'message' => 'Enviado'
        ], Response::HTTP_OK);
    }
}

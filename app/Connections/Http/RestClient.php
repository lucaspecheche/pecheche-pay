<?php

namespace App\Connections\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;

abstract class RestClient
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function execute(string $method, string $url, array $options): ?RestResponse
    {
        try {
            $response = $this->client->request($method, $url);
            return RestResponse::success($response);
        } catch (BadResponseException $exception) {
            return RestResponse::failure($exception);
        }
    }

    public function get(string $url, array $query = []): RestResponse
    {
        return $this->execute(__FUNCTION__, $url, ['query' => $query]);
    }

    public function post(string $url, array $body = []): RestResponse
    {
        return $this->execute(__FUNCTION__, $url, ['json' => $body]);
    }
}

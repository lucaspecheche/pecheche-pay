<?php

namespace Transactions\Connections\Gateway;

use App\Connections\Http\RestResponse;

interface GatewayClientInterface
{
    public function get(string $url, array $query = []): RestResponse;

    public function post(string $url, array $body = []): RestResponse;
}

<?php

namespace Transactions\Connections\Inform;

use App\Connections\Http\RestResponse;

interface InformClientInterface
{
    public function get(string $url, array $query = []): RestResponse;

    public function post(string $url, array $body = []): RestResponse;
}

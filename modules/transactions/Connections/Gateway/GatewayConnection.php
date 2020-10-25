<?php

namespace Transactions\Connections\Gateway;

use Illuminate\Http\Client\PendingRequest;
use Transactions\Models\Transaction;

class GatewayConnection
{
    protected $gatewayClient;

    private const AUTHORIZATION_KEY = 'Autorizado';

    public function __construct(PendingRequest $gatewayClient)
    {
        $this->gatewayClient = $gatewayClient;
    }

    public function transferIsAuthorized(Transaction $transaction): bool
    {
        $response = $this->gatewayClient->post(GatewayRoutes::authorizeTransfer(), $transaction->toArray());
        return $response->successful() && $response->json('message') === self::AUTHORIZATION_KEY;

    }
}

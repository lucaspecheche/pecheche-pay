<?php

namespace Transactions\Connections\Gateway;

use Transactions\Models\Transaction;

class GatewayConnection
{
    protected $gatewayClient;

    private const AUTHORIZATION_KEY = 'Autorizado';

    public function __construct(GatewayClientInterface $gatewayClient)
    {
        $this->gatewayClient = $gatewayClient;
    }

    public function transferIsAuthorized(Transaction $transaction): bool
    {
        $response = $this->gatewayClient->post(GatewayRoutes::authorizeTransfer(), $transaction->toArray());
        return $response->isSuccess() && $response->get('message') === self::AUTHORIZATION_KEY;

    }
}

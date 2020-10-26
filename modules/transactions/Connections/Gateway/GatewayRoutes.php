<?php

namespace Transactions\Connections\Gateway;

final class GatewayRoutes
{
    private const NAMESPACE = 'v3/';

    public static function authorizeTransfer($suffix = ''): string
    {
        return self::NAMESPACE . '8fafdd68-a090-496f-8c9a-3442cf30dae6' . $suffix;
    }
}

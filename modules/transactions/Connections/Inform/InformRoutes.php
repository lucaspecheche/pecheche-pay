<?php

namespace Transactions\Connections\Inform;

final class InformRoutes
{
    private const NAMESPACE = 'v3/';

    public static function sendMsg(string $suffix = ''): string
    {
        return self::NAMESPACE . 'b19f7b9f-9cbf-4fc6-ad22-dc30601aec04' . $suffix;
    }
}

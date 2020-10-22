<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public static function getActionName(string $action): string
    {
        $callClass = static::class;

        return "$callClass@$action";
    }
}

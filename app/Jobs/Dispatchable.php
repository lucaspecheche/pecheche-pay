<?php

namespace App\Jobs;

use Illuminate\Contracts\Bus\Dispatcher;
use Laravel\Lumen\Bus\PendingDispatch;

trait Dispatchable
{
    public static function dispatch()
    {
        return new PendingDispatch(new static(...func_get_args()));
    }

    public static function dispatchNow()
    {
        return app(Dispatcher::class)->dispatchNow(new static(...func_get_args()));
    }
}

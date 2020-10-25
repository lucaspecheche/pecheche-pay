<?php

namespace App\Connections\Http;

use App\Exceptions\BuildException;
use Illuminate\Http\Response;

class ConnectionExceptions extends BuildException
{
    public static function error(\Exception $exception): ConnectionExceptions
    {
        return (new static())
            ->setMessage($exception->getMessage())
            ->setHttpCode(Response::HTTP_MISDIRECTED_REQUEST);
    }
}

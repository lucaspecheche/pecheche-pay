<?php

namespace Transactions\Exceptions;

use App\Exceptions\BuildException;
use Illuminate\Http\Response;

class ConnectionExceptions extends BuildException
{
    public static function errorSendMsg(string $description = ''): ConnectionExceptions
    {
        return (new static())
            ->setShortMessage(__FUNCTION__)
            ->setMessage(trans('transaction::exceptions.connections.informError'))
            ->setDescription($description)
            ->setHttpCode(Response::HTTP_MISDIRECTED_REQUEST);
    }
}

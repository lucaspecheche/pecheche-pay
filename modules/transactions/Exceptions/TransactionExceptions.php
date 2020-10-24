<?php

namespace Transactions\Exceptions;

use App\Exceptions\BuildException;
use Illuminate\Http\Response;

class TransactionExceptions extends BuildException
{
    public static function balanceUnavailable(): TransactionExceptions
    {
        return (new self)
            ->setShortMessage(__FUNCTION__)
            ->setMessage(trans('transaction::exceptions.balanceUnavailable'))
            ->setHttpCode(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}

<?php

namespace Transactions\Transfer\Exceptions;

use App\Exceptions\BuildException;
use Illuminate\Http\Response;

class TransferExceptions extends BuildException
{
    public static function balanceUnavailable(): TransferExceptions
    {
        return (new self)
            ->setShortMessage(__FUNCTION__)
            ->setMessage(trans('transaction::exceptions.balanceUnavailable'))
            ->setHttpCode(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}

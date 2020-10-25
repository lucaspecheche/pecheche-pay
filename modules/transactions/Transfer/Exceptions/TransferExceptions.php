<?php

namespace Transactions\Transfer\Exceptions;

use App\Exceptions\BuildException;
use Illuminate\Http\Response;

class TransferExceptions extends BuildException
{
    public static function insufficientFunds(): TransferExceptions
    {
        return (new self)
            ->setShortMessage(__FUNCTION__)
            ->setMessage(trans('transaction::exceptions.insufficientFunds'))
            ->setHttpCode(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}

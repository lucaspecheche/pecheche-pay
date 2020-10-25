<?php

namespace Wallets\Exceptions;

use App\Exceptions\BuildException;
use Illuminate\Http\Response;

class WalletExceptions extends BuildException
{
    public static function debitError(): WalletExceptions
    {
        return (new static())
            ->setMessage(trans('wallet::exceptions.debitError'))
            ->setHttpCode(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}

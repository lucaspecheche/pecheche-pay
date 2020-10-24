<?php

namespace Transactions\Contracts;

use Transactions\Helpers\Data\NewTransactionData;

interface TransactionServiceInterface
{
    public function new(NewTransactionData $data);
}

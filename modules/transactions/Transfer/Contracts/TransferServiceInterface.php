<?php

namespace Transactions\Transfer\Contracts;

use Transactions\Models\Transaction;
use Transactions\Transfer\Helpers\TransferMapper;

interface TransferServiceInterface
{
    public function new(TransferMapper $data): Transaction;

    public function submit(Transaction $transaction): void;
}

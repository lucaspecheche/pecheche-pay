<?php

namespace Transactions\Transfer\Events;

use App\Events\Event;
use Transactions\Models\Transaction;

class TransferCompleted extends Event
{
    private $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function getTransaction(): Transaction
    {
        return $this->transaction;
    }

    public static function dispatch(): void
    {
        event(new static(...func_get_args()));
    }
}

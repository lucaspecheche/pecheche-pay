<?php

namespace Transactions\Transfer\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Queue\SerializesModels;
use Transactions\Models\Transaction;

class TransferCompleted
{
    use InteractsWithSockets, SerializesModels;

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

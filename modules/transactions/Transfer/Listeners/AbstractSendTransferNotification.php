<?php

namespace Transactions\Transfer\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Transactions\Connections\Inform\InformConnection;
use Transactions\Models\Transaction;
use Transactions\Transfer\Events\TransferCompleted;

abstract class AbstractSendTransferNotification implements ShouldQueue
{
    private $informConnection;

    public $queue = 'NOTIFICATION';
    public $tries = 3;

    public function __construct(InformConnection $informConnection)
    {
        $this->informConnection = $informConnection;
    }

    public function handle(TransferCompleted $event): void
    {
        $this->informConnection->send(
            $this->buildMessage($event->getTransaction())
        );
    }

    abstract protected function buildMessage(Transaction $transaction): string;

    protected function formatValue(float $value): string
    {
        setlocale(LC_MONETARY, 'pt_BR.UTF-8');
        return money_format('%.2n', $value);
    }
}

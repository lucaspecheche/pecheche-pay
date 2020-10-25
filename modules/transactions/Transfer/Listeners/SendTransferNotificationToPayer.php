<?php

namespace Transactions\Transfer\Listeners;

use Transactions\Models\Transaction;

class SendTransferNotificationToPayer extends AbstractSendTransferNotification
{
    protected function buildMessage(Transaction $transaction): string
    {
        return trans('transaction::messages.transfer.payer.completed', [
            'name' => $transaction->payee->customerable->getName(),
            'value' => $this->formatValue($transaction->value)
        ]);
    }
}

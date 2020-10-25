<?php

namespace Transactions\Transfer\Listeners;

use Transactions\Models\Transaction;

class SendTransferNotificationToPayee extends AbstractSendTransferNotification
{
    protected function buildMessage(Transaction $transaction): string
    {
        return trans('transaction::messages.transfer.payee.completed', [
            'name' => $transaction->payer->customerable->getName(),
            'value' => $this->formatValue($transaction->value)
        ]);
    }
}

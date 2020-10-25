<?php

namespace Transactions\Providers;

use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;
use Transactions\Transfer\Events\TransferCompleted;
use Transactions\Transfer\Listeners\SendTransferNotificationToPayee;
use Transactions\Transfer\Listeners\SendTransferNotificationToPayer;

class TransactionEventProvider extends ServiceProvider
{
    protected $listen = [
        TransferCompleted::class => [
            SendTransferNotificationToPayee::class,
            SendTransferNotificationToPayer::class
        ]
    ];
}

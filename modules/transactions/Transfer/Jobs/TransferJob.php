<?php

namespace Transactions\Transfer\Jobs;

use App\Jobs\Job;
use Transactions\Constants\Types;
use Transactions\Models\Transaction;
use Transactions\Transfer\Contracts\TransferServiceInterface;

class TransferJob extends Job
{
    private $transaction;

    public $tries = 3;
    public $queue = Types::TRANSFER;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function handle(TransferServiceInterface $transferService): void
    {
        $transferService->submit($this->transaction);
    }
}

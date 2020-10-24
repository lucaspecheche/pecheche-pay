<?php

namespace Transactions\Transfer\Jobs;

use App\Jobs\Job;
use Transactions\Models\Transaction;

class TransferJob extends Job
{
    private $transaction;



    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function handle(): void
    {
        dd('Hand', $this->transaction);
    }
}

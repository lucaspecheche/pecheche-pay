<?php

namespace Transactions\Contracts;

use Transactions\Models\Transaction;

interface TransactionRepositoryInterface
{
    public function create(array $attributes): Transaction;
}

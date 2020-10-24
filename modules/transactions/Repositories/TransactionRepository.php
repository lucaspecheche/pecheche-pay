<?php

namespace Transactions\Repositories;

use App\Repositories\AbstractRepository;
use Illuminate\Database\Eloquent\Builder;
use Transactions\Contracts\TransactionRepositoryInterface as RepositoryInterface;
use Transactions\Models\Transaction;

class TransactionRepository extends AbstractRepository implements RepositoryInterface
{
    public function create(array $attributes): Transaction
    {
        return $this->query()->create($attributes);
    }

    protected function query(): Builder
    {
        return Transaction::query();
    }
}

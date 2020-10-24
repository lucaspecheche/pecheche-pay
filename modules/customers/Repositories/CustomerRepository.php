<?php

namespace Customers\Repositories;

use App\Repositories\AbstractRepository;
use Customers\Contracts\CustomerRepositoryInterface;
use Customers\Models\Customer;
use Illuminate\Database\Eloquent\Builder;

class CustomerRepository extends AbstractRepository implements CustomerRepositoryInterface
{
    public function getById(int $id): ?Customer
    {
        return $this->query()->find($id);
    }

    public function query(): Builder
    {
        return Customer::query();
    }
}

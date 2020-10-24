<?php

namespace Customers\Contracts;

use Customers\Models\Customer;

interface CustomerRepositoryInterface
{
    public function getById(int $id): ?Customer;
}

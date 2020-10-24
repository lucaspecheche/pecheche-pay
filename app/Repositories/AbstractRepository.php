<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;

abstract class AbstractRepository
{
    abstract protected function query(): Builder;
}

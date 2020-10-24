<?php

namespace App\Models;

use Illuminate\Support\Fluent;

class DataObject extends Fluent
{
    public static function new(array $attributes): DataObject
    {
        return new self($attributes);
    }
}

<?php

namespace Customers\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'customerable_id'
    ];

    public function customerable()
    {
        return $this->morphTo();
    }

    public function getType(): string
    {
        return $this->customerable_type;
    }
}

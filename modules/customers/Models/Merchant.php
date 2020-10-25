<?php

namespace Customers\Models;

use Customers\Database\Factories\MerchantFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Merchant extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'cpf',
        'email',
        'password'
    ];

    protected $hidden = [
        'password'
    ];

    public function customer(): MorphOne
    {
        return $this->morphOne(Customer::class, 'customerable');
    }

    protected static function newFactory(): MerchantFactory
    {
        return MerchantFactory::new();
    }
}

<?php

namespace Customers\Models;

use Customers\Database\Factories\CustomerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Wallets\Models\Wallet;

/**
 * @property Wallet wallet
 */
class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'customerable_type',
        'customerable_id'
    ];

    public function customerable()
    {
        return $this->morphTo();
    }

    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class, 'customer_id', 'id');
    }

    public function getType(): string
    {
        return $this->customerable_type;
    }

    protected static function newFactory(): CustomerFactory
    {
        return CustomerFactory::new();
    }
}

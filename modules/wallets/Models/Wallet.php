<?php

namespace Wallets\Models;

use Customers\Models\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Wallets\Database\Factories\WalletFactory;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'balance',
        'customer_id'
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    protected static function newFactory(): WalletFactory
    {
        return WalletFactory::new();
    }
}

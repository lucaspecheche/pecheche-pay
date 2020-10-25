<?php

namespace Transactions\Models;

use Customers\Models\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Transactions\Database\Factories\TransactionFactory;

/**
 * @property Customer payer
 * @property Customer payee
 * @property float value
 */
class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'value',
        'status',
        'type',
        'payer_id',
        'payee_id'
    ];

    protected $hidden = [
        'type',
        'payer_id',
        'payee_id',
        'created_at',
        'updated_at'
    ];

    public function payer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'payer_id', 'id');
    }

    public function payee(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'payee_id', 'id');
    }

    protected static function newFactory(): TransactionFactory
    {
        return TransactionFactory::new();
    }

    public static function make(array $attributes): Transaction
    {
        return new static($attributes);
    }
}

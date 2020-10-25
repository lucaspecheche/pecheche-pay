<?php

namespace Transactions\Models;

use Customers\Models\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Transactions\Constants\Status;
use Transactions\Database\Factories\TransactionFactory;

/**
 * @property Customer payer
 * @property Customer payee
 * @property float value
 * @property string status
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
        'updated_at',
        'payer',
        'payee'
    ];

    public function payer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'payer_id', 'id');
    }

    public function payee(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'payee_id', 'id');
    }

    public function updateStatus(string $status): bool
    {
        return $this->update(['status' => $status], ['touch' => true]);
    }

    public function isDebited(): bool
    {
        return $this->status === Status::DEBITED;
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

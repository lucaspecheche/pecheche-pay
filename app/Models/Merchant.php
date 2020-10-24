<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merchant extends UserAbstract
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

    public function customer()
    {
        return $this->morphOne(Customer::class, 'customerable');
    }

    public function isMerchant()
    {
        return true;
    }

    public function findByUid(int $uid): ?UserInterface
    {
        return self::query()->firstWhere('uid', '=', $uid);
    }
}

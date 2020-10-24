<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
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

    public function findByUid(int $uid): ?UserInterface
    {
        dump('Passou User');
        return parent::findByUid($uid);
        return self::query()->firstWhere('uid', '=', $uid);
    }
}

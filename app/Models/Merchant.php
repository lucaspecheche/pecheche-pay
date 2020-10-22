<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}

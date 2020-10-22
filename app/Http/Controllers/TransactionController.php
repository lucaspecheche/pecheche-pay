<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use App\Models\User;

class TransactionController extends Controller
{
    public function store()
    {
        dd(Merchant::all()->toArray());
//        User::query()->
    }
}

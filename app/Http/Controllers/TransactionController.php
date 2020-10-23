<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'value' => 'required|numeric',
            'payer' => 'required|exists:users,id',
//            'payee' => 'required|exists:', //Recebedor
        ]);

        dd(User::factory()->make());
    }
}

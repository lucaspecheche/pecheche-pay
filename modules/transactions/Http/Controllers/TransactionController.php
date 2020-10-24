<?php

namespace Transactions\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'value' => 'required|numeric',
            'payer' => 'required|numeric|is_customer:users',
            'payee' => 'required|numeric|is_customer'
        ]);

        dd($request->toArray());
    }
}

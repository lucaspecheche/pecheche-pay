<?php

namespace Transactions\Http\Controllers;

use App\Http\Controllers\Controller;
use Customers\Models\Customer;
use Illuminate\Http\Request;
use Wallets\Models\Wallet;

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

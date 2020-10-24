<?php

namespace Modules\Transactions\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

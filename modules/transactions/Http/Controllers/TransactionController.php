<?php

namespace Transactions\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Request;
use Transactions\Contracts\TransactionServiceInterface;
use Transactions\Helpers\Data\NewTransactionData;

class TransactionController extends Controller
{
    private $transactionService;

    public function __construct(TransactionServiceInterface $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function store(Request $request, NewTransactionData $data)
    {
        $this->validate($request, [
            'value' => 'required|numeric',
            'payer' => 'required|numeric|is_customer:users',
            'payee' => 'required|numeric|is_customer'
        ]);

        $data->setAll($request->all());

        $this->transactionService->new($data);

        dd('Fim Controller');
    }
}

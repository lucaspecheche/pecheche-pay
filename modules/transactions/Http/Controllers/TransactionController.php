<?php

namespace Transactions\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Transactions\Transfer\Contracts\TransferServiceInterface;
use Transactions\Transfer\Helpers\TransferMapper;

class TransactionController extends Controller
{
    private $transferService;

    public function __construct(TransferServiceInterface $transferService)
    {
        $this->transferService = $transferService;
    }

    public function transfer(Request $request, TransferMapper $data)
    {
        $this->validate($request, [
            'value' => 'required|numeric',
            'payer' => 'required|numeric|is_customer:users',
            'payee' => 'required|numeric|is_customer'
        ]);

        $transaction = $this->transferService->new($data->setAll($request->all()));

        $message = config('transaction.async')
            ? trans('transaction::messages.transfer.created')
            : trans('transaction::messages.transfer.completed');

        $status = config('transaction.async') ? Response::HTTP_CREATED : Response::HTTP_OK;

        return $this->response($message, $transaction, $status);
    }
}

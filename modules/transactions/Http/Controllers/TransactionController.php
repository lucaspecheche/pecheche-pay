<?php

namespace Transactions\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Request;
use Illuminate\Http\Response;
use Transactions\Models\Transaction;
use Transactions\Transfer\Contracts\TransferServiceInterface;
use Transactions\Transfer\Events\TransferCompleted;
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

        return $this->response(
            trans('transaction::messages.transfer.created'),
            $transaction,
            Response::HTTP_CREATED
        );
    }
}

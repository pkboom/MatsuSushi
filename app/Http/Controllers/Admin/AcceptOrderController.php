<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Transaction;
use Illuminate\Support\Facades\Response;

class AcceptOrderController extends Controller
{
    public function __invoke(Transaction $transaction)
    {
        $transaction->update([
            'status' => Transaction::TRANSACTION_ACCEPTED,
        ]);

        return Response::json([], 204);
    }
}

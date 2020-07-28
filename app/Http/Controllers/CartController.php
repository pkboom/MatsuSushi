<?php

namespace App\Http\Controllers;

use App\Transaction;

class CartController extends Controller
{
    public function __invoke()
    {
        return view('cart', [
            'fee' => Transaction::DELIVERY_FEE,
        ]);
    }
}

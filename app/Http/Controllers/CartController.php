<?php

namespace App\Http\Controllers;

use App\Transaction;
use Inertia\Inertia;

class CartController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('Cart', [
            'fee' => Transaction::DELIVERY_FEE,
        ]);
    }
}

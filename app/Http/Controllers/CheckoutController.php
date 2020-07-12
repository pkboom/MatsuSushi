<?php

namespace App\Http\Controllers;

use App\Transaction;
use Illuminate\Support\Facades\Request;

class CheckoutController extends Controller
{
    public function create()
    {
        return view('checkout.create');
    }

    public function store()
    {
        Request::validate([
            'name' => ['required', 'max:100'],
            'address' => ['required', 'max:150'],
            'phone' => ['required', 'max:100'],
            'request' => ['nullable'],
            'orders' => ['required', 'array'],
            'orders.*' => ['required', 'integer'],
            'subtotal' => ['required', 'min:1'],
            'tax' => ['required', 'min:1'],
            'tip' => ['required', 'min:1'],
            'total' => ['required', 'min:1'],
        ]);

        $transaction = Transaction::create(
            Request::only('name', 'address', 'phone', 'request', 'subtotal', 'tax', 'tip', 'total')
        );

        $transaction->orders()->sync(Request::input('orders'));

        return view('thankyou');
    }
}

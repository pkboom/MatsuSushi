<?php

namespace App\Http\Controllers;

use App\Transaction;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class CartController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('Cart', [
            'fee' => Transaction::DELIVERY_FEE,
            'promotion' => [
                'over20' => [
                    'value' => Transaction::PROMOTION_OVER_20,
                    'name' => Cache::get(Transaction::promotionNameOver20()),
                ],
                'over50' => [
                    'value' => Transaction::PROMOTION_OVER_50,
                    'name' => Cache::get(Transaction::promotionNameOver50()),
                ],
                'over100' => [
                    'value' => Transaction::PROMOTION_OVER_100,
                    'name' => Cache::get(Transaction::promotionNameOver100()),
                ],
            ],
        ]);
    }
}

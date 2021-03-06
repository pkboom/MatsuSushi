<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Item;
use App\Transaction;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class PromotionController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Promotion/Index', [
            'title' => Cache::get(Transaction::promotionTitle()),
            'body' => Cache::get(Transaction::promotionBody()),
            'order_now' => Cache::get(Transaction::promotionOrderNow()),
            'code' => Cache::get(Transaction::promotionCode()),
            'promotions' => [
                'over20' => Cache::get(Transaction::promotionOver20()),
                'over50' => Cache::get(Transaction::promotionOver50()),
                'over100' => Cache::get(Transaction::promotionOver100()),
            ],
            'items' => Item::whereHas(
                'category',
                fn ($query) => $query->where('name', Category::PROMOTION)
            )->get(),
        ]);
    }

    public function store()
    {
        Request::validate([
            'title' => ['nullable', 'max:100'],
            'body' => ['nullable', 'string'],
            'order_now' => ['boolean'],
            'code' => ['nullable', 'max:100'],
            'over20' => ['nullable', 'exists:items,id'],
            'over50' => ['nullable', 'exists:items,id'],
            'over100' => ['nullable', 'exists:items,id'],
        ]);

        Cache::put(Transaction::promotionTitle(), Request::input('title'));
        Cache::put(Transaction::promotionBody(), Request::input('body'));
        Cache::put(Transaction::promotionOrderNow(), Request::input('order_now'));
        Cache::put(Transaction::promotionCode(), Request::input('code'));
        Cache::put(Transaction::promotionOver20(), Request::input('over20'));
        Cache::put(Transaction::promotionNameOver20(), optional(Item::find(Request::input('over20')))->name);
        Cache::put(Transaction::promotionOver50(), Request::input('over50'));
        Cache::put(Transaction::promotionNameOver50(), optional(Item::find(Request::input('over50')))->name);
        Cache::put(Transaction::promotionOver100(), Request::input('over100'));
        Cache::put(Transaction::promotionNameOver100(), optional(Item::find(Request::input('over100')))->name);

        return Redirect::back()->with('success', 'Promotion saved.');
    }
}

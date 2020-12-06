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
            'promotions' => [
                Transaction::promotionOver20() => Cache::get(Transaction::promotionOver20()),
                Transaction::promotionOver50() => Cache::get(Transaction::promotionOver50()),
                Transaction::promotionOver100() => Cache::get(Transaction::promotionOver100()),
            ],
            'items' => Item::query()
                ->whereHas('category', function ($query) {
                    $query->where('name', Category::PROMOTION);
                })->get(),
        ]);
    }

    public function store()
    {
        Request::validate([
            Transaction::promotionOver20() => ['nullable', 'exists:items,id'],
            Transaction::promotionOver50() => ['nullable', 'exists:items,id'],
            Transaction::promotionOver100() => ['nullable', 'exists:items,id'],
        ]);

        Cache::put(Transaction::promotionOver20(), Request::input(Transaction::promotionOver20()));
        Cache::put(Transaction::promotionOver50(), Request::input(Transaction::promotionOver50()));
        Cache::put(Transaction::promotionOver100(), Request::input(Transaction::promotionOver100()));

        return Redirect::back()->with('success', 'Promotion saved.');
    }
}

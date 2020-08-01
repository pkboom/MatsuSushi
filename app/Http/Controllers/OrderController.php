<?php

namespace App\Http\Controllers;

use App\Category;

class OrderController extends Controller
{
    public function __invoke()
    {
        return view('order', [
            'popular_menu' => Category::POPULAR_MENU,
            'categories' => Category::with('items')
                ->orderBy('priority', 'desc')
                ->get(),
        ]);
    }
}

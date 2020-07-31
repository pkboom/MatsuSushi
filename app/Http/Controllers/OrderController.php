<?php

namespace App\Http\Controllers;

use App\Category;

class OrderController extends Controller
{
    public function __invoke()
    {
        return view('order', [
            'categories' => Category::with('items')
                ->orderBy('priority', 'desc')
                ->get(),
        ]);
    }
}

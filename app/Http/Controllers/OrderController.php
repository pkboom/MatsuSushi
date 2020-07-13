<?php

namespace App\Http\Controllers;

use App\Category;

class OrderController extends Controller
{
    public function index()
    {
        return view('orders.index', [
            'categories' => Category::with('items')->get(),
        ]);
    }
}

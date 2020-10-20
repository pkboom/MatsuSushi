<?php

namespace App\Http\Controllers;

use App\Category;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('Order', [
            'popularMenu' => Category::POPULAR_MENU,
            'categories' => Category::with('items')
                ->orderByRaw('priority is null, priority asc')
                ->get(),
        ]);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Transaction;
use Inertia\Inertia;

class StatsController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('Stats/Index', [
            'transactions' => Transaction::select('id')
                ->get(),
        ]);
    }
}

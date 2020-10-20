<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class MenuController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('Menu');
    }
}

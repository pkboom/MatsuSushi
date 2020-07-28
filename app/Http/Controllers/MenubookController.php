<?php

namespace App\Http\Controllers;

class MenubookController extends Controller
{
    public function __invoke()
    {
        return view('menubook');
    }
}

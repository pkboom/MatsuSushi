<?php

namespace App\Http\Controllers;

use App\Transaction;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;

class StartYourOrderController extends Controller
{
    public function create()
    {
        return view('start-your-order', [
            'online_order_enabled' => Cache::get('online_order_enabled', Transaction::ONLINE_ORDER_DISABLED),
        ]);
    }

    public function store()
    {
        $request = Request::validate([
            'type' => ['required', 'in:'.implode(',', Transaction::TYPE)],
            'first_name' => ['required', 'max:50'],
            'last_name' => ['required', 'max:50'],
            'phone' => ['required', 'max:50'],
            'address' => ['nullable', 'required_if:type,delivery', 'max:250'],
            'takeout_time' => ['nullable', 'required_if:type,takeout', 'max:50'],
            'message' => ['nullable', 'string'],
            'items' => ['required', 'array'],
            'items.*' => ['required', 'exists:items,id'],
            'tip_percentage' => ['required', 'in:0,0.05,0.10,0.15,0.20,0.25,0.30'],
            ]);

        Session::put('order', $request);

        return Response::json($request);
    }
}

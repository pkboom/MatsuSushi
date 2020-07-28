<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class DisableReservationsController extends Controller
{
    public function create()
    {
        return Inertia::render('Reservations/Disable/Create', [
            'closed_days' => Cache::get('closed_days'),
            'closed_dates' => Cache::get('closed_dates', []),
        ]);
    }

    public function store()
    {
        Request::validate([
            'days' => ['nullable', 'max:50'],
            'dates' => ['nullable', 'array'],
            'dates.*' => ['nullable', 'date'],
        ]);

        $closed_dates = collect(Request::input('dates'))
            ->filter()
            ->values()
            ->toArray();

        Cache::put('closed_days', Request::input('days'));
        Cache::put('closed_dates', $closed_dates);

        return Redirect::back()->with('success', 'Setup complete.');
    }
}

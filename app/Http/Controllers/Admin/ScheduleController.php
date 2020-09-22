<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class ScheduleController extends Controller
{
    public function index()
    {
        return Inertia::render('Schedule/Index', [
            'schedule' => [
                'online_order_available' => Cache::get('online_order_available'),
                'closed_day' => Cache::get('closed_day'),
                'closed_dates' => Cache::get('closed_dates', []),
                'opening_hours_from' => Cache::get('opening_hours_from'),
                'opening_hours_to' => Cache::get('opening_hours_to'),
            ],
        ]);
    }

    public function store()
    {
        Request::validate([
            'online_order_available' => ['required', 'boolean'],
            'closed_day' => ['nullable', 'max:50'],
            'closed_dates' => ['nullable', 'array'],
            'closed_dates.*' => ['nullable', 'date'],
            'opening_hours_from' => ['required', 'date_format:g:ia'],
            'opening_hours_to' => ['required', 'date_format:g:ia'],
        ]);

        $closed_dates = collect(Request::input('closed_dates'))
            ->filter()
            ->values()
            ->toArray();

        Cache::put('online_order_available', Request::input('online_order_available'));
        Cache::put('closed_day', Request::input('closed_day'));
        Cache::put('closed_dates', $closed_dates);
        Cache::put('opening_hours_from', Request::input('opening_hours_from'));
        Cache::put('opening_hours_to', Request::input('opening_hours_to'));

        return Redirect::back()->with('success', 'Schedule updated.');
    }
}

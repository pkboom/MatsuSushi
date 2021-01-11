<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Transaction;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class SettingsController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Settings/Index', [
            'schedule' => [
                'closed_day' => Cache::get('closed_day'),
                'closed_dates' => Cache::get('closed_dates', []),
                'opening_hours_from' => Cache::get('opening_hours_from'),
                'opening_hours_to' => Cache::get('opening_hours_to'),
            ],
            'online_order_available' => Cache::get('online_order_available'),
            'takeout_times' => Transaction::TAKEOUT_AVAILABLE_TIMES,
            'takeout_available_after' => Cache::get('takeout_available_after'),
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
            'takeout_available_after' => ['required', 'in:'.implode(',', Transaction::TAKEOUT_AVAILABLE_TIMES)],
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
        Cache::put('takeout_available_after', Request::input('takeout_available_after'));

        return Redirect::back()->with('success', 'Settings saved.');
    }
}

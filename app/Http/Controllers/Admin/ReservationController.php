<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Reservation;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class ReservationController extends Controller
{
    public function index()
    {
        return Inertia::render('Reservations/Index', [
            'filters' => Request::all('search'),
            'reservations' => Reservation::latest()
                ->filter(Request::only('search'))
                ->paginate()
                ->transform(function ($reservation) {
                    return [
                        'id' => $reservation->id,
                        'name' => $reservation->name,
                        'phone' => $reservation->phone,
                        'people' => $reservation->people,
                        'reserved_at' => $reservation->reserved_at->format('Y-m-d h:i a'),
                        'created_at' => $reservation->created_at->format('Y-m-d'),
                    ];
                }),
        ]);
    }

    public function create()
    {
        return Inertia::render('Reservations/Create');
    }

    public function store()
    {
        Request::validate([
            'first_name' => ['required', 'max:50'],
            'last_name' => ['required', 'max:50'],
            'phone' => ['required', 'max:50'],
            'date' => ['required', 'date'],
            'time' => ['required', 'date_format:g:ia'],
            'people' => ['required', 'integer', 'between:1,30'],
            'message' => ['nullable', 'string'],
        ]);

        $reserved_at = CarbonImmutable::parse(Request::input('date'))->modify(Request::input('time'));

        $reservation = Reservation::create(
            Request::only('first_name', 'last_name', 'phone', 'people', 'message') + [
                'reserved_at' => $reserved_at,
        ]);

        return Redirect::route('admin.reservations.edit', $reservation->id)->with('success', 'Reservation created.');
    }

    public function edit(Reservation $reservation)
    {
        return Inertia::render('Reservations/Edit', [
            'reservation' => [
                'id' => $reservation->id,
                'first_name' => $reservation->first_name,
                'last_name' => $reservation->last_name,
                'phone' => $reservation->phone,
                'date' => $reservation->reserved_at->format('F j, Y'),
                'time' => $reservation->reserved_at->format('g:ia'),
                'people' => $reservation->people,
                'message' => $reservation->message,
            ],
        ]);
    }

    public function update(Reservation $reservation)
    {
        Request::validate([
            'first_name' => ['required', 'max:50'],
            'last_name' => ['required', 'max:50'],
            'phone' => ['required', 'max:50'],
            'date' => ['required', 'date'],
            'time' => ['required', 'date_format:g:ia'],
            'people' => ['required', 'integer', 'between:1,30'],
            'message' => ['nullable', 'string'],
        ]);

        $reserved_at = CarbonImmutable::parse(Request::input('date'))->modify(Request::input('time'));

        $reservation->update(
            Request::only('first_name', 'last_name', 'phone', 'people', 'message') + [
                'reserved_at' => $reserved_at,
        ]);

        return Redirect::back()->with('success', 'Reservation updated.');
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return Redirect::route('admin.reservations')->with('success', 'Reservation deleted.');
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Reservation;
use Carbon\CarbonImmutable;
use Carbon\CarbonInterval;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class ReservationController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Reservations/Index', [
            'filters' => Request::all('search'),
            'reservations' => Reservation::query()
                ->whereDate('booked_at', '>=', now()->startOfDay())
                ->oldest('booked_at')
                ->filter(Request::only('search'))
                ->paginate()
                ->transform(function ($reservation) {
                    return [
                        'id' => $reservation->id,
                        'name' => $reservation->name,
                        'phone' => $reservation->phone,
                        'people' => $reservation->people,
                        'booked_at' => $reservation->booked_at->format('m-d h:i a'),
                        'created_at' => $reservation->created_at->format('m-d'),
                    ];
                }),
        ]);
    }

    public function show()
    {
        $startOfWeek = CarbonImmutable::now()->startOfWeek(CarbonImmutable::SUNDAY);

        $dates = [];

        foreach ($startOfWeek->range(now()->addDays(Reservation::VALID_DAYS)->endOfWeek(CarbonImmutable::SATURDAY), CarbonInterval::day()) as $date) {
            $dates[$date->format('n/j')] = null;
        }

        Reservation::query()
            ->where('booked_at', '>=', $startOfWeek)
            ->get()
            ->map(function ($reservation) use (&$dates) {
                $dates[$reservation->booked_at->format('n/j')][] = [
                    'id' => $reservation->id,
                    'name' => $reservation->name,
                    'phone' => $reservation->phone,
                    'people' => $reservation->people,
                    'time' => $reservation->time,
                ];
            });

        return Inertia::render('Admin/Reservations/Show', [
            'dates' => $dates,
            'today' => now()->format('n/j'),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Reservations/Create');
    }

    public function store()
    {
        Request::validate([
            'first_name' => ['required', 'max:50'],
            'last_name' => ['required', 'max:50'],
            'phone' => ['required', 'max:50'],
            'date' => ['required', 'date', 'after:yesterday'],
            'time' => ['required', 'date_format:g:ia'],
            'people' => ['required', 'integer', 'between:1,30'],
            'message' => ['nullable', 'string'],
        ]);

        $booked_at = CarbonImmutable::parse(Request::input('date'))->modify(Request::input('time'));

        $reservation = Reservation::create(
            Request::only('first_name', 'last_name', 'phone', 'people', 'message') + [
                'booked_at' => $booked_at,
        ]);

        return Redirect::route('admin.reservations.edit', $reservation->id)->with('success', 'Reservation created.');
    }

    public function edit(Reservation $reservation)
    {
        return Inertia::render('Admin/Reservations/Edit', [
            'reservation' => [
                'id' => $reservation->id,
                'first_name' => $reservation->first_name,
                'last_name' => $reservation->last_name,
                'phone' => $reservation->phone,
                'date' => $reservation->booked_at->format('F j, Y'),
                'time' => $reservation->booked_at->format('g:ia'),
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
            'date' => ['required', 'date', 'after:yesterday'],
            'time' => ['required', 'date_format:g:ia'],
            'people' => ['required', 'integer', 'between:1,30'],
            'message' => ['nullable', 'string'],
        ]);

        $booked_at = CarbonImmutable::parse(Request::input('date'))->modify(Request::input('time'));

        $reservation->update(
            Request::only('first_name', 'last_name', 'phone', 'people', 'message') + [
                'booked_at' => $booked_at,
        ]);

        return Redirect::back()->with('success', 'Reservation updated.');
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return Redirect::route('admin.reservations')->with('success', 'Reservation deleted.');
    }
}

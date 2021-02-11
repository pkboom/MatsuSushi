<?php

namespace App\Http\Controllers;

use App\Reservation;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Spatie\Honeypot\EncryptedTime;

class ReservationController extends Controller
{
    public function create()
    {
        return Inertia::render('Reservations/Create', [
            'encrypted_time' => (string) EncryptedTime::create(now()->addSecond()),
        ]);
    }

    public function store()
    {
        if (Request::isSpam()) {
            return Redirect::back();
        }

        Request::validate([
            'first_name' => ['required', 'max:50'],
            'last_name' => ['required', 'max:50'],
            'phone' => ['required', 'max:50'],
            'date' => ['required', 'date', 'after:today'],
            'time' => ['required', 'date_format:g:ia'],
            'people' => ['required', 'integer', 'between:1,30'],
            'message' => ['nullable', 'string'],
        ]);

        $reserved_at = CarbonImmutable::parse(Request::input('date'))
            ->modify(Request::input('time'));

        if (Reservation::onClosedDates($reserved_at)) {
            validation_fails('date', 'Sorry, we are closed on '.$reserved_at->format('M j').'.');
        }

        if (Reservation::isDuplicate(Request::input('phone'), $reserved_at)) {
            validation_fails('date', "Your reservation on {$reserved_at->format('F j')} is already confirmed.");
        }

        if (Reservation::isFarFuture($reserved_at)) {
            validation_fails('date', 'Reservation is available until '.now()->addDays(Reservation::VALID_DAYS)->format('Y-m-d').'.');
        }

        $reservation = Reservation::create(
            Request::only('first_name', 'last_name', 'phone', 'people', 'message') + [
                'reserved_at' => $reserved_at,
            ]
        );

        return Redirect::route('reservations.show', $reservation);
    }

    public function show(Reservation $reservation)
    {
        return Inertia::render('Reservations/Show', [
            'reservation' => [
                'name' => $reservation->name(),
                'phone' => $reservation->phone,
                'people' => $reservation->people,
                'message' => $reservation->message,
                'reserved_at' => $reservation->reserved_at->format('F j, h:i a'),
            ],
        ]);
    }
}

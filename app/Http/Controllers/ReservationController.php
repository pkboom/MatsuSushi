<?php

namespace App\Http\Controllers;

use App\Reservation;
use Carbon\CarbonImmutable;
use Carbon\CarbonInterval;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Spatie\Honeypot\EncryptedTime;

class ReservationController extends Controller
{
    public function create()
    {
        return view('reservation', [
            'reservation_enabled' => 1,
            'encrypted_time' => EncryptedTime::create(now()->addSecond()),
        ]);
    }

    public function store()
    {
        if (Request::isSpam()) {
            return Response::json([], 400);
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

        if ($reserved_at->isClosed()) {
            fail_validation('date', 'Sorry, we are closed on '.$reserved_at->format('l').'s.');
        }

        if (Reservation::onClosedDates($reserved_at)) {
            fail_validation('date', 'Reservation is not available.');
        }

        if (Reservation::isDuplicate(Request::input('phone'), $reserved_at)) {
            fail_validation('date', "Your reservation on {$reserved_at->format('F j')} is already confirmed.");
        }

        if (Reservation::isFuture($reserved_at)) {
            fail_validation('date', 'Reservation is available within 3 weeks.');
        }

        Reservation::create(
            Request::only('first_name', 'last_name', 'phone', 'people', 'message') + [
                'reserved_at' => $reserved_at,
            ]
        );

        Cache::put('new_reservation', true, CarbonInterval::hours(1));

        return Response::json([
            'message' => "Thank you! Your reservation on {$reserved_at->format('F j')} has been confirmed!",
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Events\ReservationComplete;
use App\Reservation;
use Carbon\CarbonImmutable;
use Exception;
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
        if (!Request::has('matsu_honeypot')) {
            return Response::json([], 400);
        }

        if (Request::input('matsu_honeypot') !== null) {
            return Response::json([], 400);
        }

        try {
            (new EncryptedTime(Request::input('encrypted_time')))->isFuture();
        } catch (Exception $decryptException) {
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

        $reserved_at = CarbonImmutable::parse(Request::input('date'))->modify(Request::input('time'));

        if ($reserved_at->dayOfWeek === (int) Cache::get('closed_days')) {
            fail_validation('date', 'Sorry, we are closed on Tuesdays.');
        }

        collect(Cache::get('closed_dates'))->each(function ($date) use ($reserved_at) {
            if ($reserved_at->isSameday($date)) {
                fail_validation('date', 'Reservation is not available.');
            }
        });

        Reservation::create(
            Request::only('first_name', 'last_name', 'phone', 'people', 'message') + [
                'reserved_at' => $reserved_at,
        ]);

        event(new ReservationComplete());

        return Response::json([
            'message' => "Thank you! Your reservation on {$reserved_at->format('F j')} has been confirmed!",
        ]);
    }
}

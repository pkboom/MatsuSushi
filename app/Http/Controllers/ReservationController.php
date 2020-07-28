<?php

namespace App\Http\Controllers;

use App\Events\ReservationComplete;
use App\Reservation;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

class ReservationController extends Controller
{
    public function create()
    {
        return view('reservation', [
            'reservation_enabled' => 1,
        ]);
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

        Reservation::create(
            Request::only('first_name', 'last_name', 'phone', 'people', 'message') + [
                'reserved_at' => $reserved_at,
        ]);

        event(new ReservationComplete());

        return Response::json([
            'message' => 'Your reservation is confirmed! Thanks.',
        ]);
    }
}

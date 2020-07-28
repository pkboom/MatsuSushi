<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Reservation;
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
    }

    public function edit(Reservation $reservation)
    {
    }
}

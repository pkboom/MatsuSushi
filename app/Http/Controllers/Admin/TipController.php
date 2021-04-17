<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Transaction;
use Carbon\CarbonImmutable;
use Carbon\CarbonInterval;
use Inertia\Inertia;

class TipController extends Controller
{
    public function __invoke()
    {
        $startOfWeek = CarbonImmutable::now()->subWeek()->startOfWeek(CarbonImmutable::SUNDAY);

        $dates = [];

        foreach ($startOfWeek->range($startOfWeek->addWeeks(2)->subDay(), CarbonInterval::day()) as $date) {
            $dates[$date->format('n/j')] = null;
        }

        Transaction::query()
            ->where('created_at', '>=', $startOfWeek)
            ->whereStatus(Transaction::TRANSACTION_SUCCEEDED)
            ->get()
            ->filter()
            ->map(function ($transaction) use (&$dates) {
                $dates[$transaction->created_at->format('n/j')][] = [
                    'tip' => $transaction->tip,
                    // 'delivery_tip' => $transaction->delivery_tip,
                ];
            });

        return Inertia::render('Admin/Tips', [
            'dates' => collect($dates)->map(
                fn ($date) => [
                    'tip' => round(collect($date)->sum('tip'), 2),
                    // 'delivery_tip' => round(collect($date)->sum('delivery_tip'), 2),
                ]
            ),
            'today' => now()->format('n/j'),
        ]);
    }
}

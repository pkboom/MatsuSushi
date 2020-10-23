<?php

namespace App\Http\Controllers\Reports;

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
            ->where('created_at', '>=', now()->startOfDay())
            ->whereStatus(Transaction::TRANSACTION_SUCCEEDED)
            ->get()
            ->filter()
            ->map(function ($transaction) use (&$dates) {
                $dates[$transaction->created_at->format('n/j')][] = [
                    'tip' => $transaction->tip,
                    'afternoonTip' => $transaction->afternoonTip,
                ];
            });

        return Inertia::render('Admin/Reports/Tips', [
            'dates' => collect($dates)->map(fn ($date) => [
                    'tip' => collect($date)->sum('tip'),
                    'afternoonTip' => collect($date)->sum('afternoonTip'),
                ]
            ),
            'today' => now()->format('n/j'),
        ]);
    }
}

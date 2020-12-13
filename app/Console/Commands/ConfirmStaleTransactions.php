<?php

namespace App\Console\Commands;

use App\Transaction;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ConfirmStaleTransactions extends Command
{
    protected $signature = 'confirm:transaction';

    public function handle()
    {
        Transaction::query()
            ->staleAndPending()
            ->get()
            ->each->confirm()
            ->whenNotEmpty(
                fn ($transactions) => Log::info('Transaction confirmed: '.$transactions->pluck('id')->implode(', ')
            )
        );

        return 0;
    }
}

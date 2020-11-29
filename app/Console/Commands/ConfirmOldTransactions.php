<?php

namespace App\Console\Commands;

use App\Transaction;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ConfirmOldTransactions extends Command
{
    protected $signature = 'confirm:transaction';

    public function handle()
    {
        Transaction::query()
            ->oldAndStillInProcess()
            ->get()
            ->each->confirm();

        Log::info('hey');

        return 0;
    }
}

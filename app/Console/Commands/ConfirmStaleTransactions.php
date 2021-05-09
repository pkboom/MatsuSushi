<?php

namespace App\Console\Commands;

use App\Transaction;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class ConfirmStaleTransactions extends Command
{
    protected $signature = 'confirm:transactions';

    public function handle()
    {
        Transaction::query()
            ->staleAndPending()
            ->get()
            ->each(function ($transaction) {
                Stripe::setApiKey(config('services.stripe.secret'));

                Log::info('Transaction confirmed: '.$transaction->id);

                try {
                    $paymentIntent = PaymentIntent::retrieve($transaction->stripe_id);

                    $paymentIntent->status === Transaction::TRANSACTION_SUCCEEDED
                        ? $transaction->succeeded()
                        : $transaction->failed($paymentIntent->status);
                } catch (Exception $e) {
                    $transaction->failed($e->getMessage());
                }
            });

        return 0;
    }
}

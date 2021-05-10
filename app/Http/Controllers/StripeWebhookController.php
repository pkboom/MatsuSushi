<?php

namespace App\Http\Controllers;

use App\Transaction;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class StripeWebhookController extends Controller
{
    public function handleWebhook()
    {
        $method = 'handle'.Str::studly(str_replace('.', '_', Request::input('type')));

        if (method_exists($this, $method)) {
            $response = $this->{$method}();

            return $response;
        }

        return $this->missingMethod();
    }

    public function handleCheckoutSessionCompleted()
    {
        $transaction = Transaction::whereStripeId(Request::input('data.object.payment_intent'))->firstOrFail();

        $transaction->succeeded();

        return $this->successMethod();
    }

    public function handleChargeRefunded()
    {
        $transaction = Transaction::whereStripeId(Request::input('data.object.payment_intent'))->firstOrFail();

        $transaction->refunded();

        return $this->successMethod();
    }

    public function handleChargeRefundUpdated()
    {
        $transaction = Transaction::whereStripeId(Request::input('data.object.payment_intent'))->firstOrFail();

        $transaction->failed(Request::input('data.object.reason'), Transaction::TRANSACTION_REFUND_FAILED);

        return $this->successMethod();
    }

    protected function successMethod()
    {
        return new Response('Webhook Handled', 200);
    }

    protected function missingMethod()
    {
        return new Response();
    }
}

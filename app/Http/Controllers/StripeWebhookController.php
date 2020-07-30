<?php

namespace App\Http\Controllers;

use App\Events\OrderPlaced;
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

        $transaction->update([
            'status' => Transaction::TRANSACTION_SUCCEEDED,
        ]);

        $transaction->items()->attach(explode(',', Request::input('data.object.metadata.items')));

        event(new OrderPlaced());

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

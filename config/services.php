<?php

return [
    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'webhook' => [
            'secret' => env('STRIPE_WEBHOOK_SECRET'),
            'tolerance' => env('STRIPE_WEBHOOK_TOLERANCE', 300),
        ],
    ],

    'kakao' => [
        'client_id' => env('KAKAO_CLIENT_ID'),
        'redirect_uri' => env('KAKAO_REDIRECT_URI'),
    ],
];

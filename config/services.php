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

    'tinify' => [
        'api_key' => env('TINIFY_API_KEY'),
    ],

    'googlemaps' => [
        'api_key' => env('GOOGLEMAPS_API_KEY'),
        'place_id' => env('GOOGLEMAPS_PLACE_ID'),
    ],
];

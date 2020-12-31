<?php

namespace App\Http\Controllers;

use App\Transaction;
use Carbon\CarbonInterval;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function __invoke()
    {
        $options = [
            'key' => config('services.googlemaps.api_key'),
            'placeid' => config('services.googlemaps.place_id'),
            'fields' => 'rating,reviews,user_ratings_total',
         ];

        $query = http_build_query($options);

        $url = "https://maps.googleapis.com/maps/api/place/details/json?{$query}";

        return Inertia::render('Home', [
            'reviews' => Cache::remember(
                'google_reviews',
                CarbonInterval::day(),
                fn () => Http::get($url)->json()['result']
            ),
            'title' => Cache::get(Transaction::promotionTitle()),
            'body' => str_replace("\n", '<br>', Cache::get(Transaction::promotionBody())),
        ]);
    }
}

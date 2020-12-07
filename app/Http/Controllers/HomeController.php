<?php

namespace App\Http\Controllers;

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
            // 'reviews' => Http::get($url)->json()['result'],
            'reviews' => [
                'rating' => 4.5,
                'user_ratings_total' => 337,
                'reviews' => [
                    [
                        'author_name' => 'Elizabeth',
                        'text' => 'We came here as a half-way mark to a long drive home from our honeymoon in Algonquin in early September. The staff were so thoughtful and kind, anticipating our every need and going above and beyond to exceed our expectations. The restaurant was so beautiful, cozy and clean. We got our own private booth with a beautiful window view, suggested by the staff. We were so impressed by the wonderful service and AMAZING sushi and food. Thank you so so much! We will be back soon! :) Love, The Harrisons',
                        'rating' => 5,
                    ],
                    [
                        'author_name' => 'Elizabeth',
                        'text' => 'We came here as a half-way mark to a long drive home from our honeymoon in Algonquin in early September. The staff were so thoughtful and kind, anticipating our every need and going above and beyond to exceed our expectations. The restaurant was so beautiful, cozy and clean. We got our own private booth with a beautiful window view, suggested by the staff. We were so impressed by the wonderful service and AMAZING sushi and food. Thank you so so much! We will be back soon! :) Love, The Harrisons',
                        'rating' => 5,
                    ],
                    [
                        'author_name' => 'Elizabeth',
                        'text' => 'We came here as a half-way mark to a long drive home from our honeymoon in Algonquin in early September. The staff were so thoughtful and kind, anticipating our every need and going above and beyond to exceed our expectations. The restaurant was so beautiful, cozy and clean. We got our own private booth with a beautiful window view, suggested by the staff. We were so impressed by the wonderful service and AMAZING sushi and food. Thank you so so much! We will be back soon! :) Love, The Harrisons',
                        'rating' => 5,
                    ],
                    [
                        'author_name' => 'Elizabeth',
                        'text' => 'We came here as a half-way mark to a long drive home from our honeymoon in Algonquin in early September. The staff were so thoughtful and kind, anticipating our every need and going above and beyond to exceed our expectations. The restaurant was so beautiful, cozy and clean. We got our own private booth with a beautiful window view, suggested by the staff. We were so impressed by the wonderful service and AMAZING sushi and food. Thank you so so much! We will be back soon! :) Love, The Harrisons',
                        'rating' => 5,
                    ],
                    [
                        'author_name' => 'Elizabeth',
                        'text' => 'We came here as a half-way mark to a long drive home from our honeymoon in Algonquin in early September. The staff were so thoughtful and kind, anticipating our every need and going above and beyond to exceed our expectations. The restaurant was so beautiful, cozy and clean. We got our own private booth with a beautiful window view, suggested by the staff. We were so impressed by the wonderful service and AMAZING sushi and food. Thank you so so much! We will be back soon! :) Love, The Harrisons',
                        'rating' => 5,
                    ],
                ],
            ],
        ]);
    }
}

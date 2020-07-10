<?php

use App\Image;
use Faker\Generator as Faker;

$factory->define(Image::class, function (Faker $faker) {
    return [
        'filename' => $faker->image(),
    ];
});

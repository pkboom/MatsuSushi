<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use App\Menu;
use Faker\Generator as Faker;

$factory->define(Menu::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'category_id' => factory(Category::class),
        'description' => $faker->sentence,
        'price' => (string) $faker->randomFloat(2, 9, 30),
    ];
});

<?php

use Faker\Generator as Faker;

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Category::class, function (Faker $faker) {
    return [
        'name' => $faker->word
    ];
});

$factory->define(App\Menu::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'category_id' => factory(App\Category::class),
        'descript' => $faker->paragraph,
        'price' => (string) $faker->randomNumber
    ];
});

$factory->define(App\Image::class, function (Faker $faker) {
    return [
        'filename' => $faker->image(),
    ];
});

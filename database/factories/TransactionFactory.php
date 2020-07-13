<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Transaction;
use Faker\Generator as Faker;

$factory->define(Transaction::class, function (Faker $faker) {
    return [
        'stripe_id' => $faker->uuid,
        'name' => $faker->name,
        'phone' => $faker->phoneNumber,
        'address' => $faker->address,
        'subtotal' => $faker->numberBetween(10, 50),
        'tip' => $faker->randomElement([0, 5, 10, 15, 20, 25, 30]),
        'request' => $faker->paragraph,
        'status' => $faker->boolean(90) ? 'success' : 'refund',
     ];
});

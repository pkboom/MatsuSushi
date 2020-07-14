<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Transaction;
use Faker\Generator as Faker;

$factory->define(Transaction::class, function (Faker $faker) {
    return [
        'stripe_id' => $faker->uuid,
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->email,
        'phone' => $faker->phoneNumber,
        'address' => $faker->address,
        'subtotal' => $faker->numberBetween(10, 50),
        'tip' => $faker->randomElement([0, 0.05, 0.10, 0.15, 0.20, 0.25, 0.30]),
        'request' => $faker->paragraph,
        'status' => $faker->boolean(90) ? 'success' : 'refund',
     ];
});

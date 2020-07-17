<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Transaction;
use Faker\Generator as Faker;

$factory->define(Transaction::class, function (Faker $faker) {
    $type = $faker->randomElement(['delivery', 'takeout']);
    $optional = $type === 'delivery' ?
        ['address' => $faker->address] :
        ['takeout_time' => $faker->randomElement(['1:00pm', '3:00pm', '6:00pm'])];

    return [
        'stripe_id' => $faker->uuid,
        'type' => $type,
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'phone' => $faker->phoneNumber,
        'subtotal' => $faker->numberBetween(10, 50),
        'tip_percentage' => $faker->randomElement([0, 0.05, 0.10, 0.15, 0.20, 0.25, 0.30]),
        'message' => $faker->paragraph,
        'status' => $faker->randomElement(['success', 'refund', 'fail']),
     ] + $optional;
});

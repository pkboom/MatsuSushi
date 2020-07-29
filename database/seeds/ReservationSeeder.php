<?php

use App\Reservation;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    public function run()
    {
        factory(Reservation::class, 3)->create();

        factory(Reservation::class, 3)->create([
            'reserved_at' => now()->subDays(3),
        ]);

        foreach (range(1, 20) as $count) {
            factory(Reservation::class)->create([
                'reserved_at' => now()->addDays(mt_rand(1, 20)),
            ]);
        }
    }
}

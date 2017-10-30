<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

    	$faker = Faker::create();
    	factory(App\Chatroom::class, 10)->create([
    		'user_id' => 3,
    		'room_id' => $faker->unique()->uuid,
    		'occupied' => 0
    	]);
    }
}

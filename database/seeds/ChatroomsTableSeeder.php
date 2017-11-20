<?php

use Illuminate\Database\Seeder;

class ChatroomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	App\Chatroom::insert([
    		'id' => 999,
    		'user_id' => 999,
    	]);
    }
}

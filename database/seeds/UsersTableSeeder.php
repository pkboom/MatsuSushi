<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
	const CHATROOMCOUNT = 5;
	const USERNAME = 'Rachel';
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	// dummy customer record
    	App\User::insert([
	        'name' => 'customer',
	        'email' => 'customer@matsu.com',
	        'password' => bcrypt('g4ngka!f[gf4sD'),
    	]);

    	// initial admin record
    	$id = App\User::insertGetId([
	        'name' => self::USERNAME,
	        'email' => 'admin@matsu.com',
	        'password' => bcrypt('a'),
    	]);

    	// create chatrooms for an admin
    	// create initial message for chatroom
    	for($i =0; $i < self::CHATROOMCOUNT; $i++){
	   		$data = tap(new App\Chatroom([
	   			'user_id' => $id,
	   		]))->save();
	   		(new App\Message([
	   			'user_id' => $id,
	   			'username' => self::USERNAME,
	   			'chatroom_id' => $data['id'],
	   			'message' => 'Disconnected',
	   			'status' => 'initial',
	   		]))->save();
    	}
    }
}

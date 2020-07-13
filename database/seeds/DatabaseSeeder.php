<?php

use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'first_name' => 'Matsu',
            'last_name' => 'Sushi',
            'email' => 'admin@matsu.com',
            'password' => bcrypt('asdfasdf'),
        ]);

        $this->call(GallerySeeder::class);
    }
}

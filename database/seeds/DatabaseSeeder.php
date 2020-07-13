<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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

        DB::unprepared(file_get_contents(database_path('category_menu.sql')));

        $this->call(GallerySeeder::class);

        $this->call(TransactionSeeder::class);
    }
}

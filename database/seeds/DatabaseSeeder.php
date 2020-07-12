<?php

use App\Category;
use App\Menu;
use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'James',
            'email' => 'admin@matsu.com',
            'password' => bcrypt('asdfasdf'),
        ]);

        factory(Category::class, 20)->create()->each(function ($category) {
            foreach (range(1, rand(5, 15)) as $value) {
                factory(Menu::class)->create([
                    'category_id' => $category->id,
                ]);
            }
        });
    }
}

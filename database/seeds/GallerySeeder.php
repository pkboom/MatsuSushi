<?php

use App\Image;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    public function run()
    {
        foreach (range(1, 30) as $value) {
            Image::create([
                'filename' => 'example.jpeg',
            ]);
        }
    }
}

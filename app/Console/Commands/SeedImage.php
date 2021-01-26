<?php

namespace App\Console\Commands;

use App\Image;
use Illuminate\Console\Command;

class SeedImage extends Command
{
    protected $signature = 'seed:images';

    public function handle()
    {
        Image::truncate();

        foreach (glob(storage_path('app/public/*')) as $filename) {
            $filename = preg_replace('/.*public\//', '', $filename);

            Image::create([
                'filename' => $filename,
            ]);
        }

        return 0;
    }
}

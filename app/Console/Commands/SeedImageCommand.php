<?php

namespace App\Console\Commands;

use App\Image;
use Illuminate\Console\Command;

class SeedImageCommand extends Command
{
    protected $signature = 'seed:images';

    public function handle()
    {
        Image::truncate();

        foreach (glob(storage_path('app/public/*')) as $filename) {
            $filename = str_replace('/home/y/code/matsusushi/storage/app/public/', '', $filename);

            Image::create([
                'filename' => $filename,
            ]);
        }

        return 0;
    }
}

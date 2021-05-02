<?php

namespace App\Console\Commands;

use App\Image;
use Illuminate\Console\Command;
use kornrunner\Blurhash\Blurhash;

class BlurImage extends Command
{
    protected $signature = 'image:blur';

    public function handle()
    {
        Image::all()->each(function ($model) {
            $image = imagecreatefromstring(file_get_contents(storage_path("app/public/{$model->filename}")));

            $sourceWidth = imagesx($image);
            $sourceHeight = imagesy($image);

            $percent = collect([0.5, 0.4, 0.3, 0.2, 0.1])
                ->skipWhile(fn ($percent) => round($sourceWidth * $percent) > 500)
                ->first();

            $percent = is_null($percent) ? 0.1 : $percent;

            $width = round($sourceWidth * $percent);
            $height = round($sourceHeight * $percent);

            $blurImage = imagecreatetruecolor($width, $height);

            imagecopyresized($blurImage, $image, 0, 0, 0, 0, $width, $height, $sourceWidth, $sourceHeight);

            $pixels = [];

            for ($y = 0; $y < $height; ++$y) {
                $row = [];
                for ($x = 0; $x < $width; ++$x) {
                    $index = imagecolorat($image, $x, $y);
                    $colors = imagecolorsforindex($image, $index);

                    $row[] = [$colors['red'], $colors['green'], $colors['blue']];
                }
                $pixels[] = $row;
            }

            $components_x = 4;
            $components_y = 3;

            $blurhash = Blurhash::encode($pixels, $components_x, $components_y);

            $model->update([
                'blurhash' => $blurhash,
            ]);
            
            $this->info($blurhash);
        });

        return 0;
    }
}

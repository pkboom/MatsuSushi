<?php

namespace Tests\Unit;

use App\Image;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_image_can_be_stored()
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('image.jpg');

        Image::store($file);

        Storage::disk('public')->assertExists($file->hashName());

        $this->assertDatabaseHas('images', [
            'filename' => $file->hashName(),
        ]);
    }
}

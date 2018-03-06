<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class ImageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_image_can_be_stored()
    {
        Storage::fake('public');

        Storage::disk('public')->makeDirectory('thumbs');

        $file = UploadedFile::fake()->image('image.jpg');

        Image::store($file);

        Storage::disk('public')->assertExists($file->hashName());
        Storage::disk('public')->assertExists('thumbs/' . $file->hashName());

        $this->assertDatabaseHas('images', [
            'filename' => $file->hashName(),
        ]);
    }
}

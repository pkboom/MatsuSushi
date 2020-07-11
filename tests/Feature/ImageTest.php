<?php

namespace Tests\Feature;

use App\Image;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_see_gallery()
    {
        $image = create(Image::class);

        $response = $this->getJson('/gallery')->json();

        $this->assertCount(1, $response);
        $this->assertEquals($image->filename, $response[0]['filename']);
    }

    /** @test */
    public function guests_may_not_upload_images()
    {
        $this->post('/upload')
            ->assertRedirect('login');
    }

    /** @test */
    public function au_admin_can_upload_images()
    {
        $this->signIn();

        Storage::fake('public');

        $this->post('/upload', [
                'images' => [$file = UploadedFile::fake()->image('image.jpg')],
            ]);

        Storage::disk('public')->assertExists($file->hashName());

        $this->assertDatabaseHas('images', [
            'filename' => $file->hashName(),
        ]);
    }

    /** @test */
    public function only_images_can_be_uploaded()
    {
        $this->signIn()
            ->post('/upload', [
                'images' => [UploadedFile::fake()->create('anyfile.txt', 1)],
            ])
            ->assertSessionHasErrors('images.0');
    }

    /** @test */
    public function a_guest_may_not_delete_an_image()
    {
        $this->delete('/upload/1')
            ->assertRedirect('login');
    }

    /** @test */
    public function an_admin_can_delete_an_image()
    {
        $this->withoutExceptionHandling();
        $this->signIn();

        Storage::fake('public');

        $this->post('/upload', [
                'images' => [$file = UploadedFile::fake()->image('image.jpg')],
            ]);

        $this->delete('/upload/1');

        Storage::disk('public')->assertMissing($file->hashName());

        $this->assertDatabaseMissing('images', [
            'filename' => $file->hashName(),
        ]);
    }
}

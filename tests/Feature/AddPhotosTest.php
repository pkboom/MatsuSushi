<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddPhotosTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function only_authorized_users_can_upload_photos()
    {
        $this->withExceptionHandling();

        $this->post('/admin/upload-image')
            ->assertStatus(302);
    }

    /** @test */
    public function a_valid_image_must_be_provided()
    {
        $this->withExceptionHandling()->signIn();
    }
}

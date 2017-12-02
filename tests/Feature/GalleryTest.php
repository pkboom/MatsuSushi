<?php

namespace Tests\Feature;

use Tests\TestCase;

class GalleryTest extends TestCase
{
    public function test_gallery_shows()
    {
        $response = $this->get('gallery');

        $response->assertStatus(200);
    }
}

<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Category;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_category_has_its_own_path()
    {
        $category = create(Category::class);

        $this->assertEquals("/menu/categories/{$category->name}", $category->path());
    }
}

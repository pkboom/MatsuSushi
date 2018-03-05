<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Menu;

class MenuTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_menu_item_has_a_path()
    {
        $item = create(Menu::class);

        $this->assertEquals('/menu/categories/1/items/1', $item->path());
    }
}

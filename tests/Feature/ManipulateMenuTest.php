<?php

namespace Tests\Feature;

use App\Category;
use App\Menu;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ManipulateMenuTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_may_not_create_a_menu_item()
    {
        $this->post('/menu/categories/1')
            ->assertRedirect('login');
    }

    /** @test */
    public function an_admin_can_add_a_menu()
    {
        $this->signIn();

        $category = create(Category::class);

        $menu = make(Menu::class, [
            'category_id' => $category->id,
        ]);

        $this->post($category->path(), $menu->toArray());

        $this->assertDatabaseHas('menus', [
            'name' => $menu->name,
        ]);
    }

    /** @test */
    public function a_guest_may_not_edit_a_menu_item()
    {
        $this->patch('/menu/categories/1/items/1')
            ->assertRedirect('login');
    }

    /** @test */
    public function an_admin_can_edit_a_menu_item()
    {
        $this->signIn();

        $menu = create(Menu::class);

        $this->patch($menu->path(), [
            'name' => 'something new',
            'price' => '1',
            'description' => 'new description',
        ]);

        $this->assertDatabaseHas('menus', [
            'name' => 'something new',
        ]);
    }

    /** @test */
    public function a_guest_may_not_delete_a_menu_item()
    {
        $this->delete('/menu/categories/1/items/1')
            ->assertRedirect('login');
    }

    /** @test */
    public function an_admin_can_delete_a_menu_item()
    {
        $this->signIn();

        $menu = create(Menu::class);

        $this->deleteJson($menu->path());

        $this->assertDatabaseMissing('menus', [
            'name' => $menu->name,
        ]);
    }
}

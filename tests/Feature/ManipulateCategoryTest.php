<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Category;
use App\Menu;

class ManipulateCategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_get_menu_categories()
    {
        $this->withoutExceptionHandling();

        $category = create(Category::class);

        $response = $this->getJson('/menu/categories')->json();

        $this->assertEquals($response[0]['name'], $category->name);
    }

    /** @test */
    public function a_user_can_get_menu_items_for_a_given_cateroy()
    {
        $category = create(Category::class);

        $menu = create(Menu::class, [
            'category_id' => $category->id,
        ]);

        $response = $this->getJson($category->path())->json();

        $this->assertCount(1, $response);
    }

    /** @test */
    public function a_guest_may_not_add_a_category()
    {
        $this->post('/menu/categories')
            ->assertRedirect('login');
    }

    /** @test */
    public function an_admin_can_add_a_category()
    {
        $this->signIn();

        $category = make(Category::class);

        $this->post('/menu/categories', $category->toArray());

        $this->assertDatabaseHas('categories', [
            'name' => $category->name
        ]);
    }

    /** @test */
    public function a_guest_may_not_delete_a_category()
    {
        $this->delete('/menu/categories/1')
            ->assertRedirect('login');
    }

    /** @test */
    public function an_admin_can_delete_a_category()
    {
        $this->signIn();

        $category = create(Category::class);

        $menu = create(Menu::class, [
            'category_id' => $category->id,
        ]);

        $this->delete($category->path());

        $this->assertDatabaseMissing('categories', [
            'name' => $category->name
        ]);

        $this->assertDatabaseMissing('menus', [
            'name' => $menu->name
        ]);
    }

    /** @test */
    public function a_guest_may_not_update_a_category()
    {
        $this->patch('/menu/categories/1')
            ->assertRedirect('login');
    }

    /** @test */
    public function an_admin_can_update_a_category()
    {
        $this->withoutExceptionHandling();
        $this->signIn();

        $category = create(Category::class);

        $this->patchJson($category->path(), [
            'name' => 'something new'
        ]);

        $this->assertDatabaseHas('categories', [
            'name' => 'something new'
        ]);
    }
}

<?php

namespace Tests\Feature;

use App\Category;
use App\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ManipulateCategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_get_item_categories()
    {
        $this->withoutExceptionHandling();

        $category = create(Category::class);

        $response = $this->getJson('/item/categories')->json();

        $this->assertEquals($response[0]['name'], $category->name);
    }

    /** @test */
    public function a_user_can_get_items_for_a_given_cateroy()
    {
        $category = create(Category::class);

        $item = create(Item::class, [
            'category_id' => $category->id,
        ]);

        $response = $this->getJson($category->path())->json();

        $this->assertCount(1, $response);
    }

    /** @test */
    public function a_guest_may_not_add_a_category()
    {
        $this->post('/item/categories')
            ->assertRedirect('login');
    }

    /** @test */
    public function a_guest_may_not_delete_a_category()
    {
        $this->delete('/item/categories/1')
            ->assertRedirect('login');
    }

    /** @test */
    public function an_admin_can_delete_a_category()
    {
        $this->signIn();

        $category = create(Category::class);

        $item = create(Item::class, [
            'category_id' => $category->id,
        ]);

        $this->delete($category->path());

        $this->assertDatabaseMissing('categories', [
            'name' => $category->name,
        ]);

        $this->assertDatabaseMissing('items', [
            'name' => $item->name,
        ]);
    }

    /** @test */
    public function a_guest_may_not_update_a_category()
    {
        $this->patch('/item/categories/1')
            ->assertRedirect('login');
    }

    /** @test */
    public function an_admin_can_update_a_category()
    {
        $this->signIn();

        $category = create(Category::class);

        $this->patchJson($category->path(), [
            'name' => 'something new',
        ]);

        $this->assertDatabaseHas('categories', [
            'name' => 'something new',
        ]);
    }

    /** @test */
    public function a_category_should_be_unique()
    {
        $this->signIn();

        $category = create(Category::class);

        $categoryWithSameName = make(Category::class, [
           'name' => $category->name,
        ]);

        $this->post('/item/categories', $categoryWithSameName->toArray())
            ->assertSessionHasErrors('name');
    }
}

<?php

namespace Tests\Feature;

use App\Category;
use App\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_may_not_create_a_item()
    {
        $this->post('/item/categories/1')
            ->assertRedirect('login');
    }

    /** @test */
    public function an_admin_can_add_a_item()
    {
        $this->signIn();

        $category = create(Category::class);

        $item = make(Item::class, [
            'category_id' => $category->id,
        ]);

        $this->post($category->path(), $item->toArray());

        $this->assertDatabaseHas('items', [
            'name' => $item->name,
        ]);
    }

    /** @test */
    public function a_guest_may_not_edit_a_item()
    {
        $this->patch('/item/categories/1/items/1')
            ->assertRedirect('login');
    }

    /** @test */
    public function an_admin_can_edit_a_item()
    {
        $this->signIn();

        $item = create(Item::class);

        $this->patch($item->path(), [
            'name' => 'something new',
            'price' => '1',
            'description' => 'new description',
        ]);

        $this->assertDatabaseHas('items', [
            'name' => 'something new',
        ]);
    }

    /** @test */
    public function a_guest_may_not_delete_a_item()
    {
        $this->delete('/item/categories/1/items/1')
            ->assertRedirect('login');
    }

    /** @test */
    public function an_admin_can_delete_a_item()
    {
        $this->signIn();

        $item = create(Item::class);

        $this->deleteJson($item->path());

        $this->assertDatabaseMissing('items', [
            'name' => $item->name,
        ]);
    }
}

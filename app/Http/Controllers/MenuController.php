<?php

namespace App\Http\Controllers;

use App\Menu;
use Illuminate\Support\Facades\Request;
use App\Category;

class MenuController extends Controller
{
    public function store(Category $category)
    {
        $data = request()->validate([
            'name' => 'required|string|max:100',
            'price' => 'required|string|max:50',
            'descript' => 'required|string'
            ]);

        return $category->menu()->create($data);
    }

    public function update($category, Menu $item)
    {
        $data = request()->validate([
            'name' => 'required|string|max:100',
            'price' => 'required|string|max:50',
            'descript' => 'required|string'
        ]);

        $item->update($data);

        return response([], 204);
    }

    public function destroy($category, Menu $item)
    {
        $item->delete();

        return response([], 204);
    }
}

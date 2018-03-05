<?php

namespace App\Http\Controllers;

use App\Category;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('menu')->get();

        if (request()->wantsJson()) {
            return $categories;
        }

        return view('menu.category', compact('categories'));
    }

    public function show(Category $category)
    {
        $menu = $category->menu;

        if (request()->wantsJson()) {
            return $menu;
        }

        return view('menu.item', compact('category', 'menu'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:50'
        ]);

        return Category::create($data);
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return response([], 204);
    }

    public function update(Category $category)
    {
        $data = request()->validate([
            'name' => 'required|string|max:50'
        ]);

        $category->update($data);

        return response([], 204);
    }
}

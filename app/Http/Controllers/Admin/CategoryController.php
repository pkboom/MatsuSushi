<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
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
            'name' => 'required|string|unique:categories|max:50',
            ]);

        return response(Category::create($data), 201);
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return response([], 204);
    }

    public function update(Category $category)
    {
        request()->validate([
                'name' => 'required|string|unique:categories|max:50',
        ]);

        $category->update([
            'name' => request('name'),
            'slug' => Str::slug(request('name')),
        ]);

        if (request()->wantsJson()) {
            return $category;
        }

        return response([], 204);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index()
    {
        return Inertia::render('Categories/Index', [
            'filters' => Request::all('search'),
            'categories' => Category::latest()
                ->filter(Request::only('search'))
                ->paginate(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Categories/Create');
    }

    public function store()
    {
        $category = Category::create(
            Request::validate([
                'name' => ['required', 'max:100', Rule::unique('categories')],
                'priority' => ['nullable', 'integer', 'between:1,9'],
            ])
        );

        return Redirect::route('admin.categories.edit', $category)->with('success', 'Category created.');
    }

    public function edit(Category $category)
    {
        return Inertia::render('Categories/Edit', [
            'category' => $category->load('items'),
        ]);
    }

    public function update(Category $category)
    {
        $category->update(
            Request::validate([
                'name' => ['required', 'max:100', Rule::unique('categories')->ignore($category->id)],
                'priority' => ['nullable', 'integer', 'between:1,9'],
            ])
        );

        return Redirect::back()->with('success', 'Category updated.');
    }

    public function destroy(Category $category)
    {
        $category->items->each->delete();

        $category->delete();

        return Redirect::route('admin.categories')->with('success', 'Category deleted.');
    }
}

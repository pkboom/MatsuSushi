<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index()
    {
        return Inertia::render('Categories/Index', [
            'filters' => Request::all('search'),
            'categories' => Category::latest()
                ->filter(Request::only('search'))
                ->paginate()
                ->transform(function ($course) {
                    return [
                        'id' => $course->id,
                        'name' => $course->name,
                    ];
                }),
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
            ])
        );

        return Redirect::route('categories.edit', $category)->with('success', 'Category created.');
    }

    public function edit(Category $category)
    {
        return Inertia::render('Categories/Edit', [
            'category' => $category->only('id', 'name', 'domain', 'api_key', 'skillspass_key', 'skillspass_token', 'skillspass_secret', 'deleted_at'),
        ]);
    }

    public function update(Category $category)
    {
        $category->update(
            Request::validate([
                'name' => ['required', 'max:100', Rule::unique('categories')->ignore($category->id)],
            ])
        );

        return Redirect::back()->with('success', 'Category updated.');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return Redirect::route('categories')->with('success', 'Category deleted.');
    }
}

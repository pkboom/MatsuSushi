<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
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
    }

    public function store()
    {
    }

    public function edit(Category $category)
    {
    }

    public function update(Category $category)
    {
    }

    public function destroy(Category $category)
    {
    }
}

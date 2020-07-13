<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Item;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class ItemController extends Controller
{
    public function index()
    {
        return Inertia::render('Items/Index', [
            'filters' => Request::all('search', 'category'),
            'categories' => Category::query()
                ->latest()
                ->get()
                ->map
                ->only('id', 'name'),
            'items' => Item::latest()
                ->filter(Request::only('search', 'category'))
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
        return Inertia::render('Items/Create', [
            'categories' => Category::query()
                ->latest()
                ->get()
                ->map
                ->only('id', 'name'),
        ]);
    }

    public function store()
    {
        $item = Item::create(
            Request::validate([
                'category_id' => ['required', 'exists:categories,id'],
                'name' => ['required', 'max:100'],
                'price' => ['required', 'numeric', 'min:0'],
                'description' => ['nullable', 'string'],
            ])
        );

        return Redirect::route('admin.items.edit', $item)->with('success', 'Item created.');
    }

    public function edit(Item $item)
    {
        return Inertia::render('Items/Edit', [
            'item' => $item->load('category:id,name')
                ->only('id', 'category', 'name', 'price', 'description'),
        ]);
    }

    public function update(Item $item)
    {
        $item->update(
            Request::validate([
                'name' => ['required', 'max:100'],
                'price' => ['required', 'numeric', 'min:0'],
                'description' => ['nullable', 'string'],
      ])
        );

        return Redirect::back()->with('success', 'Item updated.');
    }

    public function destroy(Item $item)
    {
        $item->delete();

        return Redirect::route('admin.items')->with('success', 'Item deleted.');
    }
}

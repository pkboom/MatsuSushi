<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Image;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Inertia\Inertia;

class ImageController extends Controller
{
    public function index()
    {
        if (Request::wantsJson()) {
            return Response::json([
                'images' => Image::latest()->paginate()
                    ->transform(function ($image) {
                        return [
                            'id' => $image->id,
                            'path' => '/storage/'.$image->filename,
                        ];
                    }),
            ]);
        }

        return Inertia::render('Images/Index', [
            'url' => route('admin.images'),
        ]);
    }

    public function create()
    {
        return Inertia::render('Images/Create');
    }

    public function store()
    {
        $image = Image::create(
            Request::validate([
                'category_id' => ['required', 'exists:categories,id'],
                'name' => ['required', 'max:100'],
                'price' => ['required', 'numeric', 'min:0'],
                'description' => ['nullable', 'string'],
            ])
        );

        return Redirect::route('admin.images')->with('success', 'Image created.');
    }

    public function destroy(Image $image)
    {
        $image->delete();

        return Redirect::route('admin.images')->with('success', 'Image deleted.');
    }
}

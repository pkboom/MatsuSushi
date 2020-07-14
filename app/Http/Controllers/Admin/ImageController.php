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
        Request::validate([
            'file' => ['required', 'image', 'max:5000'],
        ]);

        Image::create([
            'filename' => Request::file('file')->store(null, 'public'),
        ]);

        return response('File uploaded.');
    }

    public function destroy(Image $image)
    {
        $image->delete();

        return Redirect::route('admin.images')->with('success', 'Image deleted.');
    }
}

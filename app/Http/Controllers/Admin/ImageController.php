<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Image;
use App\Support\Tinify;
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
            'url' => ['nullable', 'required_if:file,'.null, 'string'],
            'file' => ['nullable', 'required_if:url,'.null, 'image', 'max:5000'],
        ]);

        if (Request::input('url')) {
            $image = Tinify::createFromUrl(Request::input('url'));
        } else {
            $image = Tinify::createFromPath(Request::file('file')->getRealPath());
        }

        $path = $image->resize([
                'method' => 'fit',
                'width' => 1280,
                'height' => 1280,
            ])
            ->store(storage_path('app/public/'.hrtime(true).'.png'));

        Image::create(['filename' => $path]);

        return response('Image uploaded.');
    }

    public function destroy(Image $image)
    {
        $image->delete();

        return Redirect::route('admin.images')->with('success', 'Image deleted.');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function index()
    {
        if (request()->wantsJson()) {
            return Image::all();
        }

        $images = Image::paginate(12);

        return view('images.gallery', compact('images'));
    }

    public function store()
    {
        $data = request()->validate([
            'images.*' => 'image',
        ]);

        collect($data['images'])->each(function ($file) {
            Image::store($file);
        });

        return back()->with('flash', 'Images have been uploaded.');
    }

    public function destroy(Image $image)
    {
        Storage::disk('public')->delete($image->filename);
        Storage::disk('public')->delete('thumbs/' . $image->filename);

        $image->delete();

        return response([], 204);
    }
}

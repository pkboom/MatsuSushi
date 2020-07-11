<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function index()
    {
        return response()->json([
            'images' => Image::all(),
        ]);
    }

    public function store()
    {
        $data = request()->validate([
            'images' => ['required', 'array'],
            'images.*' => ['required', 'image'],
        ]);

        collect($data['images'])->each(function ($file) {
            $path = $file->store(null, 'public');

            Image::create([
                'filename' => $path,
            ]);
        });

        return back()->with('flash', 'Images have been uploaded.');
    }

    public function destroy(Image $image)
    {
        Storage::disk('public')->delete($image->filename);

        $image->delete();

        return response([], 204);
    }
}

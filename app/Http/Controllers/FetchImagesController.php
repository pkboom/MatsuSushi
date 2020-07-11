<?php

namespace App\Http\Controllers;

use App\Image;

class FetchImagesController extends Controller
{
    public function __invoke()
    {
        return  response()->json([
            'images' => Image::latest()->paginate(),
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Upload;

class GalleryController extends Controller
{
    public function index()
    {
        $images = Upload::paginate(8);

        return view('gallery', compact('images'));
    }
}

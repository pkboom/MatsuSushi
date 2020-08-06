<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

class GalleryController extends Controller
{
    public function __invoke()
    {
        if (Request::wantsJson()) {
            return Response::json([
                'images' => Image::query()
                    // ->latest()
                    ->inRandomOrder()
                    ->paginate()
                    ->transform(function ($image) {
                        return [
                            'id' => $image->id,
                            'path' => '/storage/'.$image->filename,
                        ];
                    }),
            ]);
        }

        return view('gallery');
    }
}

<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Inertia\Inertia;

class GalleryController extends Controller
{
    public function __invoke()
    {
        if (Request::wantsJson()) {
            return Response::json([
                'images' => Image::query()
                    ->latest()
                    ->orderBy('id')
                    ->paginate()
                    ->transform(function ($image) {
                        return [
                            'id' => $image->id,
                            'blurhash' => $image->blurhash,
                            'path' => '/storage/'.$image->filename,
                        ];
                    }),
            ]);
        }
        
        return Inertia::render('Gallery');
    }
}

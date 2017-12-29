<?php

namespace App\Http\Controllers;

use App\Gallery;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class GalleryController2 extends Controller
{
    const PHOTOSPERPAGE = 8;
    const VISIBLEPAGES = 3;

    public function index($displayPage = 1)
    {
        $lastPage;
        $photos;

        $pages = collect(File::files(public_path('storage')))
            ->sort(function ($a, $b) {
                if ($a->getMTime() == $b->getMTime()) {
                    return 0;
                }
                return ($a->getMTime() < $b->getMTime()) ? 1 : -1;
            })
            ->map(function ($value) {
                return $value->getFilename();
            })
            ->values()
            ->chunk(self::PHOTOSPERPAGE)
            ->tap(function ($collection) use (&$lastPage, &$photos, $displayPage) {
                // page count
                $lastPage = $collection->count();
                // file names of requested page
                $photos = $collection[$displayPage - 1]->toArray();
            })
            ->map(function ($value, $key) {
                return $key + 1;
            })
            ->filter(function ($value) use ($displayPage) {
                return -self::VISIBLEPAGES < ($value - $displayPage) && ($value - $displayPage) < self::VISIBLEPAGES;
            })
            ->toArray();

        return view('gallery', compact('photos', 'pages', 'displayPage', 'lastPage'));
    }
}

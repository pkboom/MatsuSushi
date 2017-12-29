<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage as Storage;
use Intervention\Image\ImageManagerStatic as Image;
use App\Upload;

class UploadController2 extends Controller
{
    public function __construct()
    {
        //You must be signed in in order to create a post except index, show
        $this->middleware('auth');
    }

    public function store()
    {
        //Validate the form
        $data = request()->validate([
            'image.*' => 'image|mimes:jpeg,bmp,png|max:8000',
        ]);

        collect($data['image'])->each(function ($item, $key) {
            // store image
            // return path to the file
            // ex) public/Mxw5iOZn61sZHWUfhJht4Re67iX54biApVg8lVop.png
            $imagePath = $item->store('public');
            // $thumbPath = '/thumb/' ;
            // // get thumb path
            // $thumbPath = str_replace('/', $thumbPath, $imagePath);

            // $resizedImage = Image::make(Storage::get($imagePath))->resize(600, null, function ($constraint) {
            //     $constraint->aspectRatio();
            //     $constraint->upsize();
            // })->orientate()->encode();
            // Storage::put($thumbPath, $resizedImage);

            $imagePath = str_replace('public/', '', $imagePath);

            Upload::create([
                'filename' => $imagePath,
            ]);
        });

        return back();
    }
}

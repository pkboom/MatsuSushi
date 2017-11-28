<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage as Storage;
use Intervention\Image\ImageManagerStatic as Image;

class UploadController extends Controller
{
	public function __construct()
	{
		//You must be signed in in order to create a post except index, show
		$this->middleware('auth');
	}

	public function store() {
	    //Validate the form
		$data = request()->validate([
			'image.*' => 'image|mimes:jpeg,bmp,png|max:8000',
		]);

		$counter = 0;
		foreach( $data['image'] as $image ) {
			// /storage/app/public linked to public/storage
			$thumbPath = '/thumb/' ;
			$imagePath = $image->store('public'); // store image
			$thumbPath = str_replace('/', $thumbPath, $imagePath); // get thumb path
			$resizedImage = Image::make(Storage::get($imagePath))->resize(600, null, function ($constraint) {
				$constraint->aspectRatio();
				$constraint->upsize();
			})->orientate()->encode();
			Storage::put($thumbPath,$resizedImage);
		}
		
		return back();
	}
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage as Storage;
use Intervention\Image\ImageManagerStatic as Image;

class UploadController extends Controller
{
	public function __construct()
	{
		//You must be signed in in order to create a post except index, show
		$this->middleware('auth');
	}

	public function select() {
		return view('admin.uploadImage');
	}

	public function store() {
	    	//Validate the form
		// $images = count(request()->file('image'));
		// request()->file('image')[0]->store('image');
		
		$photos = count(request()->file('image')) - 1;

		foreach(range(0, $photos) as $index) {
			$rules['image.' . $index] = 'image|mimes:jpeg,bmp,png|max:8000';
		}

	    //Validate the form
		$this->validate(request(), $rules);

		$counter = 0;
		foreach( request()->file('image') as $image ) {
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

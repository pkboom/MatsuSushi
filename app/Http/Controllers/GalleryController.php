<?php

namespace App\Http\Controllers;

use App\Gallery;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
	const PHOTOPERPAGE = 12;
	
		// define("PHOTOPERPAGE", 10);
	public function index($displayPage = 1) {
		$storagePath = public_path() .'/storage';
		
		$fileCount = new \FilesystemIterator($storagePath, \FilesystemIterator::SKIP_DOTS);
		$fileCount = iterator_count($fileCount) - 2; // .gitignore & thumb folder
		
		// var_dump($files);
		// die();

		$files = array();
		$dir = new \DirectoryIterator($storagePath);
		// $dir = new \DirectoryIterator(public_path() . '/image');
		// 
		// get filenames
		foreach ($dir as $fileinfo) {     
			if (!$fileinfo->isDot() && $fileinfo->getFilename() != '.gitignore' ) {
				$files[] = [ 'time' => $fileinfo->getMTime(), 'filename' => $fileinfo->getFilename() ];
			}
		}

		// sort filenames according to created time
		usort($files, function ($a, $b){
			return strcmp($a["time"], $b["time"]);
		});

		// echo "<pre>";
		// var_dump($files);
		// while (list($key, $value) = each($files)) {
		// 	echo "\$files[$key]: " . $value["time"] . $value["name"] . "\n";
		// }
		// echo "</pre>";
		// die();
		
		$galleries = [];
		$startImage = ($displayPage - 1) * self::PHOTOPERPAGE;
		$endImage = $startImage + self::PHOTOPERPAGE;
		$i = -1;
		foreach ( $files as $image ){
			$i++;
			if ( $i >=  $startImage && $i < $endImage ){
				$galleries[] = $image;
			}
		}
		$lastPage = (int) ceil($fileCount  / self::PHOTOPERPAGE);
		$pages = $this->pagination($displayPage, $lastPage);

		// echo "<pre>";
		// var_dump($startImage);
		// var_dump($endImage);
		// var_dump($lastPage);
		// var_dump($pages);
		// var_dump($galleries[0]);
		// echo "</pre>";
		// die();
		return view('gallery', compact('storagePath', 'galleries', 'pages', 'displayPage', 'lastPage'));
	}

	public function index2($displayPage = 1) {
		// echo "<pre>";
		// for ($i = 1, $l = 20; $i <= $l; $i++) {
		// 	var_dump($this->pagination($i, $l));
		// }
		// echo "</pre>";
		// die();

		$startImage = ($displayPage - 1) * self::PHOTOPERPAGE;
		// $galleries = Gallery::orderBy('id', 'DESC')->take(self::PHOTOPERPAGE)->get();
		$galleries = Gallery::orderBy('id', 'DESC')->skip($startImage)->take(self::PHOTOPERPAGE)->get();
		$recordCount = Gallery::count();
		$lastPage = (int) ceil($recordCount  / self::PHOTOPERPAGE);

		$pages = $this->pagination($displayPage, $lastPage);

		return view('gallery', compact('galleries', 'pages', 'displayPage', 'lastPage'));
	}

	// https://gist.github.com/kottenator/9d936eb3e4e3c3e02598
	public function pagination($currentPage, $lastPage)	
	{
		$delta = 2;
		$left = $currentPage - $delta;
		$right = $currentPage + $delta + 1;
		$range = [];
		$rangeWithDots = [];
		$l = 0;
		
		$range[] = 1;  
		for ($i = $currentPage - $delta; $i <= $currentPage + $delta; $i++) {
			if ($i >= $left && $i < $right && $i < $lastPage && $i > 1) {
				$range[] = $i;  				
			}
		}  
		$range[] = $lastPage;  

		// var_dump($range);
		// die();

		foreach ($range as $i) {
			if ($l) {
				if ($i - $l === 2) {
					$rangeWithDots[] = $l + 1;
				} else if ($i - $l !== 1) {
					$rangeWithDots[] = '...';
				}
			}
			$rangeWithDots[] = $i;
			$l = $i;
		}

		return $rangeWithDots;
	}
}

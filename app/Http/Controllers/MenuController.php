<?php

namespace App\Http\Controllers;

use App\Category;
use App\Menu;

class MenuController extends Controller
{
	public function index() {
		// return view('menu_backup');
		return view('menu');
		// return view('menu2');
	}

	public function items($id) {
		$menu = Menu::where("category_id", $id)->get();

		return $menu;
	}

	public function category() {
		$category = Category::all();

		return $category;
	}
}

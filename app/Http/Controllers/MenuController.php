<?php

namespace App\Http\Controllers;

use App\Category;
use App\Menu;

class MenuController extends Controller
{
	public function items($id) {
		$menu = Menu::where("category_id", $id)->get();

		return $menu;
	}

	public function category() {
		$category = Category::all();

		return $category;
	}
}

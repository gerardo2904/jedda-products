<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
     public function show($id){
		$category = Category::find($id);
		$images  = $category->images;
		
		$imagesLeft  = collect();   //crea un array
		$imagesRight = collect();   //crea un array
		
		foreach ($images as $key => $image) {
			if ($key%2==0)	// Si es par lo manda al array Left, si no, lo manda al array Right.  Esto para acomodarlas en la vista.
				$imagesLeft->push($image);
			else
				$imagesRight->push($image);
		}
		
		
		return view('categories.show')->with(compact('category','imagesLeft','imagesRight'));
	}
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show($id){
		$user = User::find($id);
		$images  = $user->images;
		
		$imagesLeft  = collect();   //crea un array
		$imagesRight = collect();   //crea un array
		
		foreach ($images as $key => $image) {
			if ($key%2==0)	// Si es par lo manda al array Left, si no, lo manda al array Right.  Esto para acomodarlas en la vista.
				$imagesLeft->push($image);
			else
				$imagesRight->push($image);
		}
		
		
		return view('users.show')->with(compact('user','imagesLeft','imagesRight'));
	}
}

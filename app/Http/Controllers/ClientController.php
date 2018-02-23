<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;

class ClientController extends Controller
{
    public function show($id){
		$client = Client::find($id);
		$images  = $client->images;
		
		$imagesLeft  = collect();   //crea un array
		$imagesRight = collect();   //crea un array
		
		foreach ($images as $key => $image) {
			if ($key%2==0)	// Si es par lo manda al array Left, si no, lo manda al array Right.  Esto para acomodarlas en la vista.
				$imagesLeft->push($image);
			else
				$imagesRight->push($image);
		}
		
		
		return view('clients.show')->with(compact('client','imagesLeft','imagesRight'));
	}
}

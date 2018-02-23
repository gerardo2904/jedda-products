<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Client;
use App\ClientImage;
use File;

class ImageClientController extends Controller
{
	public function index($id)
	{
		$client = Client::find($id);
		$images = $client->images()->orderBy('featured','desc')->get();
		return view('admin.clients.images.index')->with(compact('client','images'));
	}
	
	public function store(Request $request, $id)
	{
		// guardar la imagen en nuestro proyecto
		$file  = $request->file('photo');
		$path = public_path() . '/images/clients';
		//$path = public_path();
		$fileName = uniqid() . $file->getClientOriginalName();
		$moved = $file->move($path, $fileName);
		
		// crear 1 registro en la tabla category_images
		if ($moved){
			$clientImage = new ClientImage();
			$clientImage->image = $fileName;
			// $productImage->featured = false;   // Ya esta en la definicion de la tabla esta condicion, por eso se comenta.
			$clientImage->client_id = $id;
			$clientImage->save();  //INSERT
		}
		
		return back();
	}	
	
	public function destroy(Request $request, $id)
	{
		//eliminar el archivo
		$clientImage = ClientImage::find($request->image_id);
		if (substr($clientImage->image,0,4)==="http")  // Si empieza con http o sea que es link
		{
			$deleted = true;
		}else {
			if ($clientImage->image ==="user-default.png"){
				$deleted = true;
			}else{
			$fullPath = public_path() . '/images/clients/' . $clientImage->image;
			$deleted = File::delete($fullPath);
			}
		}
		
		
		//eliminar el registro de la imagen en la bd.
		if ($deleted){
			$clientImage->delete();
		}
		
		return back();
	}
	
	public function select($id, $image){
		
		ClientImage::where('client_id',$id)->update([
			'featured' => false
		]);
		
		$clientImage = ClientImage::find($image);
		$clientImage->featured = true;
		$clientImage->save();
		
		return back();
	}

}

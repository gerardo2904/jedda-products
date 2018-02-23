<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use App\UserImage;
use File;

class ImageUserController extends Controller
{
	public function index($id)
	{
		$user = User::find($id);
		$images = $user->images()->orderBy('featured','desc')->get();
		return view('admin.users.images.index')->with(compact('user','images'));
	}
	
	public function store(Request $request, $id)
	{
		// guardar la imagen en nuestro proyecto
		$file  = $request->file('photo');
		$path = public_path() . '/images/users';
		//$path = public_path();
		$fileName = uniqid() . $file->getClientOriginalName();
		$moved = $file->move($path, $fileName);
		
		// crear 1 registro en la tabla category_images
		if ($moved){
			$userImage = new UserImage();
			$userImage->image = $fileName;
			// $productImage->featured = false;   // Ya esta en la definicion de la tabla esta condicion, por eso se comenta.
			$userImage->user_id = $id;
			$userImage->save();  //INSERT
		}
		
		return back();
	}	
	
	public function destroy(Request $request, $id)
	{
		//eliminar el archivo
		$userImage = UserImage::find($request->image_id);
		if (substr($userImage->image,0,4)==="http")  // Si empieza con http o sea que es link
		{
			$deleted = true;
		}else {
			if ($userImage->image ==="user-default.png"){
				$deleted = true;
			}else{
			$fullPath = public_path() . '/images/users/' . $userImage->image;
			$deleted = File::delete($fullPath);
			}
		}
		
		
		//eliminar el registro de la imagen en la bd.
		if ($deleted){
			$userImage->delete();
		}
		
		return back();
	}
	
	public function select($id, $image){
		
		UserImage::where('user_id',$id)->update([
			'featured' => false
		]);
		
		$userImage = UserImage::find($image);
		$userImage->featured = true;
		$userImage->save();
		
		return back();
	}
}

<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Category;
use App\CategoryImage;
use File;



class ImageCategoryController extends Controller
{
    public function index($id)
	{
		$category = Category::find($id);
		$images = $category->images()->orderBy('featured','desc')->get();
		return view('admin.categories.images.index')->with(compact('category','images'));
	}
	
	public function store(Request $request, $id)
	{
		// guardar la imagen en nuestro proyecto
		$file  = $request->file('photo');
		$path = public_path() . '/images/categories';
		//$path = public_path();
		$fileName = uniqid() . $file->getClientOriginalName();
		$moved = $file->move($path, $fileName);
		
		// crear 1 registro en la tabla category_images
		if ($moved){
			$categoryImage = new CategoryImage();
			$categoryImage->image = $fileName;
			// $productImage->featured = false;   // Ya esta en la definicion de la tabla esta condicion, por eso se comenta.
			$categoryImage->category_id = $id;
			$categoryImage->save();  //INSERT
		}
		
		return back();
	}	
	
	public function destroy(Request $request, $id)
	{
		//eliminar el archivo
		$categoryImage = CategoryImage::find($request->image_id);
		if (substr($categoryImage->image,0,4)==="http")  // Si empieza con http o sea que es link
		{
			$deleted = true;
		}else {
			if ($categoryImage->image ==="default.png"){
				$deleted = true;
			}else{
			$fullPath = public_path() . '/images/categories/' . $categoryImage->image;
			$deleted = File::delete($fullPath);
			}
		}
		
		
		//eliminar el registro de la imagen en la bd.
		if ($deleted){
			$categoryImage->delete();
		}
		
		return back();
	}
	
	public function select($id, $image){
		
		CategoryImage::where('category_id',$id)->update([
			'featured' => false
		]);
		
		$categoryImage = CategoryImage::find($image);
		$categoryImage->featured = true;
		$categoryImage->save();
		
		return back();
	}
}

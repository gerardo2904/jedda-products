<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Product;
use App\ProductImage;
use File;

class ImageController extends Controller
{
    public function index($id)
	{
		$product = Product::find($id);
		$images = $product->images()->orderBy('featured','desc')->get();
		return view('admin.products.images.index')->with(compact('product','images'));
	}
	
	public function store(Request $request, $id)
	{
		// guardar la imagen en nuestro proyecto
		$file  = $request->file('photo');
		$path = public_path() . '/images/products';
		//$path = public_path();
		$fileName = uniqid() . $file->getClientOriginalName();
		$moved = $file->move($path, $fileName);
		
		// crear 1 registro en la tabla product_images
		if ($moved){
			$productImage = new ProductImage();
			$productImage->image = $fileName;
			// $productImage->featured = false;   // Ya esta en la definicion de la tabla esta condicion, por eso se comenta.
			$productImage->product_id = $id;
			$productImage->save();  //INSERT
		}
		
		return back();
	}	
	
	public function destroy(Request $request, $id)
	{
		//eliminar el archivo
		$productImage = ProductImage::find($request->image_id);
		if (substr($productImage->image,0,4)==="http")  // Si empieza con http o sea que es link
		{
			$deleted = true;
		}else {
			if ($productImage->image ==="default.png"){
				$deleted = true;
			}else{
			$fullPath = public_path() . '/images/products/' . $productImage->image;
			$deleted = File::delete($fullPath);
			}
		}
		
		
		//eliminar el registro de la imagen en la bd.
		if ($deleted){
			$productImage->delete();
		}
		
		return back();
	}
	
	public function select($id, $image){
		
		ProductImage::where('product_id',$id)->update([
			'featured' => false
		]);
		
		$productImage = ProductImage::find($image);
		$productImage->featured = true;
		$productImage->save();
		
		return back();
	}
}

<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Company;
use App\CompanyImage;
use File;



class ImageCompanyController extends Controller
{
    public function index($id)
	{
		$company = Company::find($id);
		$images = $company->images()->orderBy('featured','desc')->get();
		return view('admin.companies.images.index')->with(compact('company','images'));
	}
	
	public function store(Request $request, $id)
	{
		// guardar la imagen en nuestro proyecto
		$file  = $request->file('photo');
		$path = public_path() . '/images/companies';
		//$path = public_path();
		$fileName = uniqid() . $file->getClientOriginalName();
		$moved = $file->move($path, $fileName);
		
		// crear 1 registro en la tabla category_images
		if ($moved){
			$companyImage = new CompanyImage();
			$companyImage->image = $fileName;
			// $productImage->featured = false;   // Ya esta en la definicion de la tabla esta condicion, por eso se comenta.
			$companyImage->company_id = $id;
			$companyImage->save();  //INSERT
		}
		
		return back();
	}	
	
	public function destroy(Request $request, $id)
	{
		//eliminar el archivo
		$companyImage = CompanyImage::find($request->image_id);
		if (substr($companyImage->image,0,4)==="http")  // Si empieza con http o sea que es link
		{
			$deleted = true;
		}else {
			if ($companyImage->image ==="default.png"){
				$deleted = true;
			}else{
			$fullPath = public_path() . '/images/companies/' . $companyImage->image;
			$deleted = File::delete($fullPath);
			}
		}
		
		
		//eliminar el registro de la imagen en la bd.
		if ($deleted){
			$companyImage->delete();
		}
		
		return back();
	}
	
	public function select($id, $image){
		
		CompanyImage::where('company_id',$id)->update([
			'featured' => false
		]);
		
		$companyImage = CompanyImage::find($image);
		$companyImage->featured = true;
		$companyImage->save();
		
		return back();
	}
}

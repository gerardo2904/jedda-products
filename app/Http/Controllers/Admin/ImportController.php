<?php

namespace App\Http\Controllers\Admin;

use App\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use File;


class ImportController extends Controller
{
    public function import()
    {

    	$file  = '/sa2.csv';
		$path = public_path();
		$fileName = $path.$file;
		dd($fileName);
    	

       	$datos = Excel::load($fileName,function($reader){})->get();
       	if (!empty($datos) && $datos->count()){
       		foreach($datos as $key => $value){
       			$producto = new Product();
       			$producto->name 			= $value->name;
       			$producto->description 		= $value->description;
       			$producto->long_description = $value->long_description;
     			$producto->id_unidad_prod 	= $value->id_unidad_prod;
     			$producto->cantidad_prod 	= $value->cantidad_prod;
     			$producto->ancho_prod 		= $value->ancho_prod;
     			$producto->etiqueta_prod 	= $value->etiqueta_prod;
     			$producto->activo 			= $value->activo;
     			$producto->category_id 		= $value->category_id;
     			$producto->subcategory_id 	= $value->subcategory_id;
     			$producto->formula 			= $value->formula;
     			$producto->roll_id 			= $value->roll_id;
     			$producto->save();
     			//dd($producto);
       		}
       	}

       		 

       		 //$results = $reader->all();
       		 //$producto->dd(); 


    }
}

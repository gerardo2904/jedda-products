<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
Use Auth;
Use DB;

use App\almproducts;
use App\Products;

Use Session;
Use Redirect;

class AlmproductController extends Controller
{
     public function index()
    {
        //$products = almproducts::paginate(10);

        $iu = Auth::user()->empresa_id; 

        $products = DB::table('almproducts as alm')
        ->join('products as art','art.id','=','alm.id_product')
        ->select(DB::raw('CONCAT(art.name," ",art.description," ",alm.etiqueta) AS articulo'),'art.id','art.name','art.description','art.id_unidad_prod','art.ancho_prod','art.activo','art.category_id','art.subcategory_id','art.formula','art.roll_id','alm.id_company','alm.existencia','alm.precioc','alm.preciov','alm.cantidad_prod','alm.etiqueta as etiqueta_prod')
        ->where('art.activo','=','1')
        ->where('alm.id_company','=',$iu)
        ->where('alm.existencia','>','0')
        ->groupBy('art.id','articulo','art.name','art.description', 'art.id_unidad_prod', 'art.activo','art.category_id','art.ancho_prod', 'art.subcategory_id','art.formula','art.roll_id','alm.id_company','alm.etiqueta', 'alm.precioc','alm.preciov','alm.cantidad_prod','alm.existencia')
        ->get();





        return view('almproducts.index')->with(compact('products'));   // listado  
    }
}




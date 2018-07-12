<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
Use Auth;
Use DB;

use App\almproducts;
use App\Products;
use App\Company;

Use Session;
Use Redirect;
Use Barryvdh\DomPDF\Facade as PDF;

class AlmproductController extends Controller
{
     public function index()
    {
        //$products = almproducts::paginate(10);

        $iu = Auth::user()->empresa_id; 

         $cia = Company::where('id','=',$iu)->first();


        $ci = DB::table('company_images')
        ->select('id','image')
        ->where('company_images.company_id','=',$iu)
        ->first();
        $cim ='/images/companies/'.$ci->image;


        $products = DB::table('almproducts as alm')
        ->join('products as art','art.id','=','alm.id_product')
        ->select(DB::raw('CONCAT(art.name," ",art.description," ",alm.etiqueta) AS articulo'),'art.id','art.name','art.description','art.id_unidad_prod','art.ancho_prod','art.activo','art.category_id','art.subcategory_id','art.formula','art.roll_id','alm.id_company',DB::raw('SUM(alm.existencia) as existencia'),'alm.precioc','alm.preciov','alm.cantidad_prod','alm.etiqueta as etiqueta_prod')
        ->where('art.activo','=','1')
        ->where('alm.id_company','=',$iu)
        ->where('alm.existencia','>','0')
        ->groupBy('art.id','articulo','art.name','art.description', 'art.id_unidad_prod', 'art.activo','art.category_id','art.ancho_prod', 'art.subcategory_id','art.formula','art.roll_id','alm.id_company','alm.etiqueta', 'alm.precioc','alm.preciov','alm.cantidad_prod')
        ->get();

        return view('almproducts.index')->with(compact('products','cia','cim'));   // listado  
    }

   public function pdf()
    {        
        $iu = Auth::user()->empresa_id; 

        $cia = Company::where('id','=',$iu)->first();

        $ci = DB::table('company_images')
        ->select('id','image')
        ->where('company_images.company_id','=',$iu)
        ->first();
        $cim =public_path() .'/images/companies/'.$ci->image;


        $ps = DB::table('almproducts as alm')
        ->join('products as art','art.id','=','alm.id_product')
        ->select(DB::raw('CONCAT(art.name," ",art.description," ",alm.etiqueta) AS articulo'),'art.id','art.name','art.description','art.id_unidad_prod','art.ancho_prod','art.activo','art.category_id','art.subcategory_id','art.formula','art.roll_id','alm.id_company',DB::raw('SUM(alm.existencia) as existencia'),'alm.precioc','alm.preciov','alm.cantidad_prod','alm.etiqueta as etiqueta_prod')
        ->where('art.activo','=','1')
        ->where('alm.id_company','=',$iu)
        ->where('alm.existencia','>','0')
        ->groupBy('art.id','articulo','art.name','art.description', 'art.id_unidad_prod', 'art.activo','art.category_id','art.ancho_prod', 'art.subcategory_id','art.formula','art.roll_id','alm.id_company','alm.etiqueta', 'alm.precioc','alm.preciov','alm.cantidad_prod')
        ->get();
            

        $pdf = PDF::loadView('almproducts.pdf.existencias', compact('ps','cia','cim'));

        return $pdf->download('existencias.pdf');
    }

    public function lote(Request $request)
    {
        //$products = almproducts::paginate(10);

        $iu = Auth::user()->empresa_id; 

         $cia = Company::where('id','=',$iu)->first();


        $ci = DB::table('company_images')
        ->select('id','image')
        ->where('company_images.company_id','=',$iu)
        ->first();
        $cim ='/images/companies/'.$ci->image;

        $query    = trim($request->get('searchText'));
        $searchText = $query;

        $products = DB::table('almproducts as alm')
        ->join('products as art','art.id','=','alm.id_product')
        ->select(DB::raw('CONCAT(art.name," ",art.description," ",alm.etiqueta) AS articulo'),'art.id','art.name','art.description','art.id_unidad_prod','art.ancho_prod','art.activo','art.category_id','art.subcategory_id','art.formula','art.roll_id','alm.id_company',DB::raw('SUM(alm.existencia) as existencia'),'alm.precioc','alm.preciov','alm.cantidad_prod','alm.etiqueta as etiqueta_prod')
        ->where('art.activo','=','1')
        ->where('alm.id_company','=',$iu)
        ->where('alm.existencia','>','0')
         ->where('alm.etiqueta','LIKE','%'.$query.'%')
        ->groupBy('art.id','articulo','art.name','art.description', 'art.id_unidad_prod', 'art.activo','art.category_id','art.ancho_prod', 'art.subcategory_id','art.formula','art.roll_id','alm.id_company','alm.etiqueta', 'alm.precioc','alm.preciov','alm.cantidad_prod')
        ->get();

        return view('almproducts.lote')->with(compact('products','cia','cim','searchText'));   // listado  
    }

   public function pdf2()
    {        
        $iu = Auth::user()->empresa_id; 

        $cia = Company::where('id','=',$iu)->first();

        $ci = DB::table('company_images')
        ->select('id','image')
        ->where('company_images.company_id','=',$iu)
        ->first();
        $cim =public_path() .'/images/companies/'.$ci->image;


        $ps = DB::table('almproducts as alm')
        ->join('products as art','art.id','=','alm.id_product')
        ->select(DB::raw('CONCAT(art.name," ",art.description," ",alm.etiqueta) AS articulo'),'art.id','art.name','art.description','art.id_unidad_prod','art.ancho_prod','art.activo','art.category_id','art.subcategory_id','art.formula','art.roll_id','alm.id_company',DB::raw('SUM(alm.existencia) as existencia'),'alm.precioc','alm.preciov','alm.cantidad_prod','alm.etiqueta as etiqueta_prod')
        ->where('art.activo','=','1')
        ->where('alm.id_company','=',$iu)
        ->where('alm.existencia','>','0')
        ->groupBy('art.id','articulo','art.name','art.description', 'art.id_unidad_prod', 'art.activo','art.category_id','art.ancho_prod', 'art.subcategory_id','art.formula','art.roll_id','alm.id_company','alm.etiqueta', 'alm.precioc','alm.preciov','alm.cantidad_prod')
        ->get();
            

        $pdf = PDF::loadView('almproducts.pdf.existencias', compact('ps','cia','cim'));

        return $pdf->download('existencias.pdf');
    }

    public function showlote($lote,$id){
        $l=$lote;
        $i=$id;
        /*$product = Product::find($id);
        $images  = $product->images;
        
        $imagesLeft  = collect();   //crea un array
        $imagesRight = collect();   //crea un array
        
        foreach ($images as $key => $image) {
            if ($key%2==0)  // Si es par lo manda al array Left, si no, lo manda al array Right.  Esto para acomodarlas en la vista.
                $imagesLeft->push($image);
            else
                $imagesRight->push($image);
        }
        */
        
        return view('almproducts.showlote')->with(compact('l','i'));
    }

}




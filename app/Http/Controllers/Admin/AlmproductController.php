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
     public function index(Request $request)
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
        ->where('alm.existencia','>',0)
        ->where('alm.etiqueta','LIKE','%'.$query.'%')
        ->orWhere('art.name','LIKE','%'.$query.'%')
        ->groupBy('art.id','articulo','art.name','art.description', 'art.id_unidad_prod', 'art.activo','art.category_id','art.ancho_prod', 'art.subcategory_id','art.formula','art.roll_id','alm.id_company','alm.etiqueta', 'alm.precioc','alm.preciov','alm.cantidad_prod')
        ->get();

        return view('almproducts.index')->with(compact('products','cia','cim','searchText'));   // listado  
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
        ->orWhere('art.name','LIKE','%'.$query.'%')
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


        $ps = DB::table('detalle_ingreso')
        ->join('ingreso','detalle_ingreso.idingreso','=','ingreso.idingreso')
        ->join('products','detalle_ingreso.id_articulo','=','products.id')
        ->select(DB::raw('CONCAT(products.name," ",products.description," ",detalle_ingreso.etiqueta) AS articulo'),'products.id','products.name','products.description','products.id_unidad_prod','products.ancho_prod','products.activo','products.category_id','products.subcategory_id','products.formula','products.roll_id','ingreso.id_empresa','detalle_ingreso.precioc','products.cantidad_prod','detalle_ingreso.etiqueta','ingreso.tipo_comprobante','ingreso.serie_comprobante','ingreso.num_comprobante','detalle_ingreso.cantidad','ingreso.fecha_hora')
        ->where('products.activo','=','1')
        ->where('ingreso.id_empresa','=',$id)
        ->where('detalle_ingreso.etiqueta','=',$lote)
        ->groupBy('products.id','products.name','products.id_unidad_prod','products.ancho_prod', 'products.formula','products.roll_id','ingreso.id_empresa','detalle_ingreso.etiqueta','detalle_ingreso.precioc','ingreso.tipo_comprobante','ingreso.serie_comprobante','ingreso.num_comprobante','products.cantidad_prod','detalle_ingreso.cantidad','ingreso.fecha_hora')
        ->first();

        
        $ph = DB::table('detalle_production_order')
        ->join('production_order', 'detalle_production_order.id_production', '=', 'production_order.id_production')
        ->join('products', 'detalle_production_order.id_producto_pt', '=', 'products.id')
        ->join('products as p', 'production_order.id_producto_mp', '=', 'p.id')
        ->join('almproducts_tempo', 'almproducts_tempo.id_production', '=', 'production_order.id_production')
        ->select(DB::raw('CONCAT(products.name," ",products.description," ",detalle_production_order.etiqueta_pt) AS articulo'), 'products.id', 'products.name', 'products.description', 'products.id_unidad_prod', 'products.ancho_prod', 'products.activo', 'products.category_id', 'products.subcategory_id', 'products.formula', 'products.roll_id', 'production_order.id_company', 'products.cantidad_prod', 'detalle_production_order.etiqueta_pt', 'production_order.orden', 'detalle_production_order.cantidad_pt', 'production_order.id_producto_mp', DB::raw('CONCAT(p.name," ",p.description," ",production_order.etiqueta_mp) AS materia'), 'production_order.fecha_hora', 'almproducts_tempo.ncantidad_prod as cantidad_despues','almproducts_tempo.cantidad_prod as cantidad_antes')
        ->where('products.activo','=','1')
        ->where('production_order.id_company','=',$id)
        ->where('detalle_production_order.etiqueta_pt','=',$lote)
        ->groupBy('products.id', 'products.name', 'products.id_unidad_prod', 'products.ancho_prod', 'products.formula', 'products.roll_id', 'production_order.id_company', 'detalle_production_order.etiqueta_pt', 'production_order.orden', 'products.cantidad_prod')
        ->orderBy('almproducts_tempo.id_production','ASC')
        ->get();

       
        
        return view('almproducts.showlote')->with(compact('l','i','ps','ph'));
    }

}




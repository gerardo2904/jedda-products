<?php

namespace App\Http\Controllers;

Use Illuminate\Http\Request;
Use App\Http\Requests\ProductionOrderRequest;
Use Auth;

Use Session;
Use Redirect;
Use Input;
Use App\Production_Order;
Use App\Detalle_Production_Order;
use App\User;
use App\Product;
use App\Unit;
use App\almproducts;
use App\Client;
use App\Company;
use App\CompanyImage;

Use DB;

Use Carbon\Carbon;
Use Response;
Use Illuminate\Support\Collection;



class ProductionOrderController extends Controller
{
    public function __construct()
    {

    }

    public function byProduction($id) {

        $mp=Product::where('id',$id)->first();
        $mpformula=$mp->formula;
        

        $pt = DB::table('products as art')
        ->join('units as un','art.id_unidad_prod','=','un.id')
          ->select(DB::raw('CONCAT(art.name," - ",art.description) AS articulo'), 'art.id','art.name','art.id_unidad_prod','art.cantidad_prod','art.ancho_prod','art.formula','art.etiqueta_prod','un.name as unidad')
          ->where('art.activo','=','1')
          ->where('art.roll_id','=','6')  // Es Producto terminado
          ->where('art.formula', '=', $mpformula)
          ->groupBy('articulo','art.id','art.formula', 'unidad')
          ->get();

        //return $mp; 
        //return Product::where('id',$id)->get();
          return $pt;
    }

    public function byMateria($id, $largo, $ancho) {

        $mp=Product::where('id',$id)->first();
        $mpformula=$mp->formula;
        $mplargo=$largo;
        $mpancho=$ancho;
        

        $pt = DB::table('products as art')
        ->join('units as un','art.id_unidad_prod','=','un.id')
          ->select(DB::raw('CONCAT(art.name," - ",art.description) AS articulo'), 'art.id','art.name','art.id_unidad_prod','art.cantidad_prod','art.ancho_prod','art.formula','art.etiqueta_prod','un.name as unidad')
          ->where('art.activo','=','1')
          ->where('art.roll_id','=','6')  // Es Producto terminado
          ->where('art.formula', '=', $mpformula)
          ->where('art.cantidad_prod', '=', $mplargo)
            ->where('art.ancho_prod', '<=', $mpancho)
          ->groupBy('articulo','art.id','art.formula', 'unidad')
          ->get();

          return $pt;
    }

    public function index (Request $request)
    {
    	if ($request)
    	{

    		$query    = trim($request->get('searchText'));
    		$ordenesp = DB::table('production_order as po')
    		 ->join('clients as p','po.idcliente','=','p.id')
    		 ->join('companies as c','po.id_company','=','c.id')
    		 ->join('detalle_production_order as dpo','po.id_production','=','dpo.id_production')
    		 ->select('po.id_production','po.fecha_hora','p.name','c.name as compan','po.estado')
    		 ->where('c.name','LIKE','%'.$query.'%')
    		 ->orderBy('po.id_production','desc')
    		 ->groupBy('po.id_production','po.fecha_hora','p.name','po.estado')
    		 ->paginate(7);
    		 return view('productionorder.production.index',["ordenesp" => $ordenesp, "searchText" => $query]);
    	}

    }

    public function create()
    {

    	$iu = Auth::user()->empresa_id; 

    	$clientes =  DB::table('clients')->get();

        //$ci  = CompanyImage::where('company_id',$iu)->first();
        $ci = DB::table('company_images')
        ->select('id','image')
        ->where('company_images.company_id','=',$iu)
        ->first();
        $cim ='/images/companies/'.$ci->image;
        




    	$materiaprima = DB::table('products as art')
    	->join('almproducts as ap','ap.id_product','=','art.id')
    	->join('units as un','art.id_unidad_prod','=','un.id')
    	  ->select(DB::raw('CONCAT(art.name," ",art.description," ",ap.etiqueta) AS articulo'), 'art.id','ap.id_product','art.name','art.ancho_prod','art.cantidad_prod','art.formula','ap.existencia','ap.etiqueta','un.name as unidad')
    	  ->where('art.activo','=','1')
    	  ->where('ap.id_company','=',$iu)
    	  ->where('ap.existencia','>','0')
    	  ->where('art.roll_id','=','2')  // Es materia prima
    	  ->groupBy('articulo','art.id','ap.etiqueta', 'ap.existencia', 'unidad')
    	  ->get();

    	$productoterminado = DB::table('products as art')
    	->join('units as un','art.id_unidad_prod','=','un.id')
    	  ->select(DB::raw('CONCAT(art.name," - ",art.description) AS articulo'), 'art.id','art.name','art.id_unidad_prod','art.cantidad_prod','art.ancho_prod','art.formula','art.etiqueta_prod','un.name as unidad')
    	  ->where('art.activo','=','1')
    	  ->where('art.roll_id','=','6')  // Es Producto terminado
    	  ->groupBy('articulo','art.id','unidad')
    	  ->get();

		$leader = DB::table('products as art')
    	->join('almproducts as ap','ap.id_product','=','art.id')
    	->join('units as un','art.id_unidad_prod','=','un.id')
    	  ->select(DB::raw('CONCAT(art.name," ",art.description," ",ap.etiqueta) AS articulo'), 'art.id','ap.id_product','art.name','art.ancho_prod','art.cantidad_prod','art.formula','ap.existencia','ap.etiqueta','ap.existencia','un.name as unidad')
    	  ->where('art.activo','=','1')
    	  ->where('ap.id_company','=',$iu)
    	  ->where('ap.existencia','>','0')
    	  ->where('art.roll_id','=','4')  // Es Leader
    	  ->groupBy('articulo','art.id','ap.etiqueta', 'ap.existencia','unidad')
    	  ->get();

    	$core = DB::table('products as art')
    	->join('almproducts as ap','ap.id_product','=','art.id')
    	->join('units as un','art.id_unidad_prod','=','un.id')
    	  ->select(DB::raw('CONCAT(art.name," ",art.description," ",ap.etiqueta) AS articulo'), 'art.id','ap.id_product','art.name','art.ancho_prod','art.cantidad_prod','art.formula','ap.existencia','ap.etiqueta','ap.existencia','un.name as unidad')
    	  ->where('art.activo','=','1')
    	  ->where('ap.id_company','=',$iu)
    	  ->where('ap.existencia','>','0')
    	  ->where('art.roll_id','=','3')  // Es core
    	  ->groupBy('articulo','art.id','ap.etiqueta', 'ap.existencia','unidad')
    	  ->get();

    	$sticker = DB::table('products as art')
    	->join('almproducts as ap','ap.id_product','=','art.id')
    	->join('units as un','art.id_unidad_prod','=','un.id')
    	  ->select(DB::raw('CONCAT(art.name," ",art.description," ",ap.etiqueta) AS articulo'), 'art.id','ap.id_product','art.name','art.ancho_prod','art.cantidad_prod','art.formula','ap.existencia','ap.etiqueta','ap.existencia','un.name as unidad')
    	  ->where('art.activo','=','1')
    	  ->where('ap.id_company','=',$iu)
    	  ->where('ap.existencia','>','0')
    	  ->where('art.roll_id','=','5')  // Es Sticker
    	  ->groupBy('articulo','art.id','ap.etiqueta', 'ap.existencia','unidad')
    	  ->get();

    	return view('productionorder.production.create',["clientes" => $clientes, "materiaprima" => $materiaprima, "productoterminado" => $productoterminado,"leader" => $leader,"core" => $core,"sticker" => $sticker, "cim" => $cim]);
    }


    public function store(ProductionOrderRequest $request)
    {
    	try{
            $msj="Ha ocurrido un error...";


    		DB::beginTransaction();

    		$iu = Auth::user()->empresa_id;
    		$u 	= Auth::user()->id;

    		$ordenproduccion = new Production_Order;

            $ordenproduccion->orden                 =   $request->get('orden');
            $ordenproduccion->orden_cliente         =   $request->get('orden_cliente');
            $ordenproduccion->id_producto_mp        =   $request->get('tempo_id_producto_mp');
            $ordenproduccion->etiqueta_mp           =   $request->get('etiqueta_mp');
            $ordenproduccion->id_producto_core      =   $request->get('tempo_id_producto_core');
            $ordenproduccion->etiqueta_core         =   $request->get('etiqueta_core');
            $ordenproduccion->id_producto_leader1   =   $request->get('tempo_id_producto_leader1');
            $ordenproduccion->etiqueta_leader1      =   $request->get('etiqueta_leader1');
            $ordenproduccion->id_producto_leader2   =   $request->get('tempo_id_producto_leader2');
            $ordenproduccion->etiqueta_leader2      =   $request->get('etiqueta_leader2');
            $ordenproduccion->id_producto_leader3   =   $request->get('tempo_id_producto_leader3');
            $ordenproduccion->etiqueta_leader3      =   $request->get('etiqueta_leader3');
            $ordenproduccion->id_producto_sticker   =   $request->get('tempo_id_producto_sticker');
            $ordenproduccion->etiqueta_sticker      =   $request->get('etiqueta_sticker');
            $ordenproduccion->direction             =   $request->get('direction'); 
            $ordenproduccion->id_user               =   $u;
            $ordenproduccion->id_company            =   $iu;
            $ordenproduccion->idcliente             =   $request->get('idcliente');
            $mytime                                 =   Carbon::now('America/Tijuana');
            $ordenproduccion->fecha_hora            =   $mytime->toDateTimeString();
            $ordenproduccion->estado                =   'A';
            $ordenproduccion->save();


/*
    		// Empiezan los detalles de la orden de produccion...
    		$corrida					= $request->get('corrida');
    		$id_producto_pt 			= $request->get('id_producto_pt');
    		$id_etiqueta_pt 			= $request->get('etiqueta_pt');
    		$cantidad_pt 				= $request->get('cantidad_pt');
    		
    		$cont = 0;

    		while ($cont < count($id_producto_pt)){
    			$detalle = new Detalle_Production_Order();
    			$detalle->id_production 	= $ordenproduccion->id_production;
                $detalle->id_producto_pt 	= $id_producto_pt[$cont];
                $detalle->etiqueta_pt 		= $etiqueta_pt[$cont];
                $detalle->cantidad_pt 		= $cantidad_pt[$cont];
                $detalle->corrida 			= $ordenproduccion->corrida;
                $detalle->estado_pt			= 'A';
    			
    			$detalle->save();


    			$cont = $cont + 1;

    		}
  */  		  
    		DB::commit();
            Session::flash('message','Se ha realizado exitosamente la insercion de la orden de producción');
            return redirect('/productionorder/production')->with('status', 'exito');;


    	}catch(\Exception $e)
    	{
            return $e;
            
            DB::rollback();
            Session::flash('message',$msj);
            return redirect('/productionorder/production')->with('status', 'noexito');;

    	}

    	return Redirect::to('productionorder/production')->with('status', 'noexito');;
    }

    public function show($id)
    {

    	$productionorder = DB::table('production_order as po')
    		 ->join('clients as p','i.idproveedor','=','p.id')
             ->join('client_images as ci','po.idcliente','=','ci.client_id')
    		 ->join('detalle_production_order as dpo','po.id_production','=','dpo.id_production')
    		 ->select('po.id_production','po.fecha_hora','p.name','ci.image','po.estado')
    		 ->where('po.id_production','=',$id)
             ->groupBy('po.id_production','po.fecha_hora','p.name','ci.image','po.estado')
    		 ->first();

    	$detalles = DB::table('detalle_production_order as dpo')
    	  ->join('products as a','dpo.id_producto_pt','=','a.id')
    	  ->select('a.name as articulo','dpo.cantidad_pt','d.etiqueta_pt')
    	  ->where('dpo.id_production','=',$id)
    	  ->get();

    	return view('productionorder.production.show',["productionorder"=>$productionorder,"detalles"=>$detalles]);
    }

    public function destroy($id)
    {
    	$productionorder  = Production_Order::findOrFail($id);
    	$productionorder->estado = 'C';
    	$productionorder->update();
    	return Redirect::to('productionorder/production');
    }
}

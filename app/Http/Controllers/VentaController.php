<?php

namespace App\Http\Controllers;


Use Illuminate\Http\Request;
Use App\Http\Requests\VentaFormRequest;
Use Auth;

Use Session;
Use Redirect;
Use Input;
Use App\Venta;
Use App\DetalleVenta;
use App\User;
use App\Product;
use App\Unit;
use App\almproducts;
use App\Client;

Use DB;

Use Carbon\Carbon;
Use Response;
Use Illuminate\Support\Collection;

class VentaController extends Controller
{
    public function __construct()
    {

    }

    public function index (Request $request)
    {
    	if ($request)
    	{
    		$query    = trim($request->get('searchText'));
    		$ventas = DB::table('venta as v')
    		 ->join('clients as p','v.idcliente','=','p.id')
    		 ->join('companies as c','v.id_empresa','=','c.id')
    		 ->join('detalle_venta as dv','v.idventa','=','dv.idventa')
    		 ->select('v.idventa','v.fecha_hora','p.name','c.name as compan','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado','total_venta')
    		 ->where('v.num_comprobante','LIKE','%'.$query.'%')
    		 ->orderBy('v.idventa','desc')
    		 ->groupBy('v.idventa','v.fecha_hora','p.name','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado')
    		 ->paginate(7);
    		 return view('ventas.venta.index',["ventas" => $ventas, "searchText" => $query]);
    	}

    }

    public function create()
    {
    	//$clientes = DB::table('clients')->where('tipo_persona','=','Proveedor')->get();

    	$iu = Auth::user()->empresa_id; 

    	$clientes =  DB::table('clients')->where('es_proveedor','=','0')->get();
    	$units =  DB::table('units')->get();
    	$articulos = DB::table('products as art')
    	->join('almproducts as ap','ap.id_product','=','art.id')
    	  ->select(DB::raw('CONCAT(art.name," ",art.description) AS articulo'), 'art.id','art.name','ap.preciov','ap.existencia')
    	  ->where('art.activo','=','1')
    	  ->where('ap.id_company','=',$iu)
    	  ->where('ap.existencia','>','0')
    	  ->groupBy('articulo','art.id','ap.preciov', 'ap.existencia')
    	  ->get();
    	return view('ventas.venta.create',["clientes" => $clientes, "products" => $articulos, "units" => $units]);
    }

    public function store(VentaFormRequest $request)
    {
    	try{


    		DB::beginTransaction();


    		$venta = new Venta;
    		$venta->idcliente	 		= $request->get('idcliente');
    		$venta->id_empresa 			= $request->get('id_empresa');
    		$venta->tipo_comprobante 	= $request->get('tipo_comprobante');
    		$venta->serie_comprobante	= $request->get('serie_comprobante');
    		$venta->num_comprobante 	= $request->get('num_comprobante');
    		$venta->total_venta			= $request->get('total_venta');
    		$mytime						= Carbon::now('America/Tijuana');
    		$venta->fecha_hora			= $mytime->toDateTimeString();
    		$venta->impuesto			= '16';
    		$venta->estado				= 'A';
    		$venta->save();

    		$id_articulo 				= $request->get('id_articulo');
    		$cantidad 					= $request->get('cantidad');
    		$preciov	 				= $request->get('preciov');
    		$descuento	 				= $request->get('descuento');


    		$etiqueta					= $request->get('etiqueta');
    		
    		$cont = 0;

    		while ($cont < count($id_articulo)){
    			$detalle = new DetalleVenta();
    			$detalle->idventa  		= $venta->idventa;
                $detalle->id_articulo 	= $id_articulo[$cont];
    			$detalle->cantidad 		= $cantidad[$cont];
    			$detalle->preciov 		= $preciov[$cont];
    			$detalle->descuento 	= $descuento[$cont];
    			$detalle->etiqueta 		= $etiqueta[$cont];
    			$detalle->save();

                
                $cantproductos = almproducts::where('id_product',$id_articulo[$cont])->count();

                if ($cantproductos > 0){
                    //$productos = almproducts::find($id_articulo[$cont]);
                    $productos = almproducts::where('id_product',$id_articulo[$cont])->first();
                    $exis=$productos->existencia;
                    //dd($productos->all());

                    
                    $productos->existencia    = $exis-$cantidad[$cont];
                    //$productos->precioc       = $precioc[$cont];
                    $productos->save(); 
                }
               /* else {
                    $productos = new almproducts();
                    $productos->id_company    = $request->get('id_empresa');
                    $productos->id_product    = $id_articulo[$cont];
                    $productos->existencia    = $cantidad[$cont];
                    $productos->precioc       = $precioc[$cont];
                    $productos->preciov       = '0';
                    $productos->id_unidad_prod= '1';
                    $productos->cantidad_prod = '1';
                    $productos->etiqueta      = 'A';
                    $productos->save();
                }
				*/

    			$cont = $cont + 1;

    		}
    		  
    		DB::commit();
            Session::flash('message','Se ha realizado exitosamente la insercion de la orden de venta');
            return redirect('/ventas/venta')->with('status', 'exito');;


    	}catch(\Exception $e)
    	{
            //return $e;
            
            DB::rollback();
            Session::flash('message','Ha ocurrido un error...');
            return redirect('/ventas/venta');

    	}

    	return Redirect::to('ventas/venta')->with('status', 'noexito');;
    }

    public function show($id)
    {
    	$venta = DB::table('venta as v')
    		 ->join('clients as p','i.idproveedor','=','p.id')
             ->join('client_images as ci','v.idcliente','=','ci.client_id')
    		 ->join('detalle_venta as dv','v.idventa','=','dv.idventa')
    		 ->select('v.idventa','v.fecha_hora','p.name','ci.image','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado','v.total_venta')
    		 ->where('v.idventa','=',$id)
             ->groupBy('v.idventa','v.fecha_hora','p.name','ci.image','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado')
    		 ->first();

    	$detalles = DB::table('detalle_venta as d')
    	  ->join('products as a','d.id_articulo','=','a.id')
    	  ->select('a.name as articulo','d.cantidad','d.preciov','d.descuento','d.etiqueta')
    	  ->where('d.idventa','=',$id)
    	  ->get();

    	return view('ventas.venta.show',["venta"=>$venta,"detalles"=>$detalles]);
    }

    public function destroy($id)
    {
    	$venta  = Venta::findOrFail($id);
    	$venta->estado = 'C';
    	$venta->update();
    	return Redirect::to('ventas/venta');
    }
}

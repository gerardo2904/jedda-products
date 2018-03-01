<?php

namespace App\Http\Controllers;

Use Illuminate\Http\Request;
Use App\Http\Requests\IngresoFormRequest;
Use Session;
Use Redirect;
Use Input;
Use App\Ingreso;
Use App\DetalleIngreso;
use App\User;
use App\Product;
use App\Unit;

Use DB;

Use Carbon\Carbon;
Use Response;
Use Illuminate\Support\Collection;

class IngresoController extends Controller
{
    public function __construct()
    {

    }

    public function index (Request $request)
    {
    	if ($request)
    	{
    		$query    = trim($request->get('searchText'));
    		$ingresos = DB::table('ingreso as i')
    		 ->join('clients as p','i.idproveedor','=','p.id')
    		 ->join('companies as c','i.id_empresa','=','c.id')
    		 ->join('detalle_ingreso as di','i.idingreso','=','di.idingreso')
    		 ->select('i.idingreso','i.fecha_hora','p.name','c.name as compan','i.tipo_comprobante','i.serie_comprobante','i.num_comprobante','i.impuesto','i.estado',DB::raw('sum(di.cantidad*precioc) as total'))
    		 ->where('i.num_comprobante','LIKE','%'.$query.'%')
    		 ->orderBy('i.idingreso','desc')
    		 ->groupBy('i.idingreso','i.fecha_hora','p.name','i.tipo_comprobante','i.serie_comprobante','i.num_comprobante','i.impuesto','i.estado')
    		 ->paginate(7);
    		 return view('compras.ingreso.index',["ingresos" => $ingresos, "searchText" => $query]);
    	}

    }

    public function create()
    {
    	//$clientes = DB::table('clients')->where('tipo_persona','=','Proveedor')->get();
    	$clientes =  DB::table('clients')->get();
    	$units =  DB::table('units')->get();
    	$articulos = DB::table('products as art')
    	  ->select(DB::raw('CONCAT(art.name," ",art.description) AS articulo'), 'art.id','art.name')
    	  ->where('art.activo','=','1')
    	  ->get();
    	return view('compras.ingreso.create',["clientes" => $clientes, "products" => $articulos, "units" => $units]);
    }

    public function store(IngresoFormRequest $request)
    {
    	try{


    		DB::beginTransaction();


    		$ingreso = new Ingreso;

    		//$ingreso->idproveedor 		= $request->get('idproveedor');
    		$ingreso->idproveedor 		= $request->get('idproveedor');
    		$ingreso->id_empresa 		= $request->get('id_empresa');
    		$ingreso->tipo_comprobante 	= $request->get('tipo_comprobante');
    		$ingreso->serie_comprobante	= $request->get('serie_comprobante');
    		$ingreso->num_comprobante 	= $request->get('num_comprobante');
    		$mytime						= Carbon::now('America/Tijuana');
    		$ingreso->fecha_hora		= $mytime->toDateTimeString();
    		$ingreso->impuesto			= '16';
    		$ingreso->estado			= 'A';
    		//$em 						= $request->get('id_empresa');
    		$ingreso->save();

    		$id_articulo 				= $request->get('id_articulo');
    		$cantidad 					= $request->get('cantidad');
    		$precioc	 				= $request->get('precioc');


    		$etiqueta					= $request->get('etiqueta');
    		
    		$cont = 0;

    		while ($cont < count($id_articulo)){
    			$detalle = new DetalleIngreso();
    			$detalle->idingreso  	= $ingreso->idingreso;
                $detalle->id_articulo 	= $id_articulo[$cont];
    			$detalle->cantidad 		= $cantidad[$cont];
    			$detalle->precioc 		= $precioc[$cont];
    			$detalle->etiqueta 		= $etiqueta[$cont];
    			$detalle->save();
    			$cont = $cont + 1;

    		}
    		
    		DB::commit();
            Session::flash('message','Se ha realizado exitosamente la insercion de la orden de compra');
            return redirect('/compras/ingreso')->with('status', 'exito');;

    	}catch(\Exception $e)
    	{
    		DB::rollback();
            Session::flash('message','Ha ocurrido un error...');
            return redirect('/compras/ingreso');
    	}

    	return Redirect::to('compras/ingreso')->with('status', 'noexito');;
    }

    public function show($id)
    {
    	$ingreso = DB::table('ingreso as i')
    		 ->join('clients as p','i.idproveedor','=','p.id')
    		 ->join('detalle_ingreso as di','i.idingreso','=','di.idingreso')
    		 ->select('i.idingreso','i.fecha_hora','p.name','i.tipo_comprobante','i.serie_comprobante','i.num_comprobante','i.impuesto','i.estado',DB::raw('sum(di.cantidad*precioc) as total'))
    		 ->where('i.idingreso','=',$id)
    		 ->first();

    	$detalles = DB::table('detalle_ingreso as d')
    	  ->join('products as a','d.id_articulo','=','a.id')
    	  ->select('a.name as articulo','d.cantidad','d.precioc','d.etiqueta')
    	  ->where('d.idingreso','=',$id)
    	  ->get();

    	return view('compras.ingreso.show',["ingreso"=>$ingreso,"detalles"=>$detalles]);
    }

    public function destroy($id)
    {
    	$ingreso  = Ingreso::findOrFail($id);
    	$ingreso->estado = 'C';
    	$ingreso->update();
    	return Redirect::to('compras/ingreso');
    }
}

<?php

namespace App\Http\Controllers;


Use Illuminate\Http\Request;
Use App\Http\Requests\VentaFormRequest;
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
Use Auth;

Use DB;

Use Carbon\Carbon;
Use Response;
Use Illuminate\Support\Collection;
Use Barryvdh\DomPDF\Facade as PDF;

class VentaController extends Controller
{
    public function __construct()
    {

    }

    public function index (Request $request)
    {
		$iu = Auth::user()->empresa_id; 
    	if ($request)
    	{
    		$query    = trim($request->get('searchText'));
    		$ventas = DB::table('venta as v')
    		 ->join('clients as p','v.idcliente','=','p.id')
    		 ->join('companies as c','v.id_empresa','=','c.id')
    		 ->join('detalle_venta as dv','v.idventa','=','dv.idventa')
    		 ->select('v.idventa','v.fecha_hora','p.name','c.name as compan','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado','v.notas','v.ordenq','total_venta')
			 ->where('v.num_comprobante','LIKE','%'.$query.'%')
			 ->where('v.id_empresa',$iu)
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
    	  ->select(DB::raw('CONCAT(art.name," ",art.description) AS articulo'), 'art.id','ap.id_product','ap.etiqueta','art.name','ap.preciov','ap.existencia')
    	  ->where('art.activo','=','1')
    	  ->where('ap.id_company','=',$iu)
    	  ->where('ap.existencia','>','0')
    	  ->groupBy('art.id','art.name','art.description','ap.etiqueta','ap.preciov', 'ap.existencia')
    	  ->get();

        // Se obtiene el cunsecutivo de Orden de Salida para que sea automatico...
        // algebra relacional para calcularlo...
        $no_ordenv = DB::table('venta')
        ->join('companies','venta.id_empresa','=','companies.id')
        ->select('venta.id_empresa', DB::raw('CONCAT(UPPER(SUBSTRING(companies.name,1,3)),"-SO-",DATE_FORMAT(NOW( ), "%H%i%S" )) as orden'), DB::raw('if(venta.num_comprobante REGEXP "^[0-9]"=1, CAST(venta.num_comprobante AS UNSIGNED) + 1 , CAST(substr(venta.num_comprobante,3,10) AS UNSIGNED) + 1) as nocompv'), DB::raw('CAST(venta.num_comprobante AS UNSIGNED) as num_comprobante'))
        ->where('venta.id_empresa','=',$iu)
        ->orderBy('num_comprobante','DESC')
        ->first();


        $ordenv='';
        $ncompv='';

        if ($no_ordenv){
            $ordenv=$no_ordenv->orden;
            $ncompv=$no_ordenv->nocompv;
        }else {
            $comp = DB::table('companies')
            ->select(DB::raw('CONCAT(UPPER(SUBSTRING(companies.name,1,3)),"-SO-",DATE_FORMAT(NOW( ), "%H%i%S" )) as orden'))
            ->where('companies.id','=',$iu)
            ->first();
            $ordenv=$comp->orden;
            $ncompv=1;
        }

        $fecha_actual=Carbon::now()->format('m/d/Y');

        ////////////////////////////////////////////////////////////////////////


    	return view('ventas.venta.create',["clientes" => $clientes, "products" => $articulos, "units" => $units, "nov" => $ordenv,"ncv" => $ncompv]);
    }

    public function store(VentaFormRequest $request)
    {
    	try{
            $msj="Ha ocurrido un error...";

			$u  = Auth::user()->id;
			$iu = Auth::user()->empresa_id; 
			

    		DB::beginTransaction();


    		$venta = new Venta;
    		$venta->idcliente	 		= $request->get('idcliente');
    		$venta->id_empresa 			= $iu;
            $venta->id_user             = $u;
    		$venta->tipo_comprobante 	= $request->get('tipo_comprobante');
    		$venta->serie_comprobante	= $request->get('serie_comprobante');
    		$venta->num_comprobante 	= $request->get('num_comprobante');
            $venta->ordenq              = $request->get('ordenq');
    		$venta->total_venta			= $request->get('total_venta');
    		$mytime						= Carbon::now('America/Tijuana');
    		$venta->fecha_hora			= $mytime->toDateTimeString();
    		$venta->impuesto			= $request->get('impuesto');
    		$venta->estado				= 'A';
            $venta->notas               = $request->get('notas');
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

                
                $cantproductos = almproducts::where([['id_product',$id_articulo[$cont]],
													['etiqueta', '=', $etiqueta[$cont]],
                                                    ['id_company', '=', $venta->id_empresa],
					])->count();

                if ($cantproductos > 0){
                    //$productos = almproducts::find($id_articulo[$cont]);
					$productos = almproducts::where([['id_product',$id_articulo[$cont]],
													['etiqueta', '=', $etiqueta[$cont]],
                                                    ['id_company', '=', $venta->id_empresa],
					])->first();
                    $exis=$productos->existencia;
                    //dd($productos->all());

                    
                    $productos->existencia    = $exis-$cantidad[$cont];
                    
                    if($productos->existencia>=0){
                        $productos->save();     
                    }else {
                        DB::rollback();
                        //Session::flash('message','Un producto excede la cantidad que se puede vender...');
                        return redirect('/ventas/venta')->with('status', 'noexito');
                        
                    }

                    
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
            Session::flash('message',$msj);
            return redirect('/ventas/venta')->with('status', 'noexito');;

    	}

    	return Redirect::to('ventas/venta')->with('status', 'noexito');;
    }

    public function show($id)
    {
    	$venta = DB::table('venta as v')
    		 ->join('clients as p','v.idcliente','=','p.id')
             ->join('client_images as ci','v.idcliente','=','ci.client_id')
    		 ->join('detalle_venta as dv','v.idventa','=','dv.idventa')
    		 ->select('v.idventa','v.fecha_hora','p.name','ci.image','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.notas','v.estado','v.total_venta','v.ordenq')
    		 ->where('v.idventa','=',$id)
             ->groupBy('v.idventa','v.fecha_hora','p.name','ci.image','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado')
    		 ->first();

    	$detalles = DB::table('detalle_venta as d')
    	  ->join('products as a','d.id_articulo','=','a.id')
    	  ->select('a.name as articulo','a.description','d.cantidad','d.preciov','d.descuento','d.etiqueta')
    	  ->where('d.idventa','=',$id)
    	  ->get();

    	return view('ventas.venta.show',["venta"=>$venta,"detalles"=>$detalles]);
    }

    public function pdf($id)
    {        
        if ($id<=0 )
            $id=4;

        $venta = DB::table('venta as v')
             ->join('clients as p','v.idcliente','=','p.id')
             ->join('client_images as ci','v.idcliente','=','ci.client_id')
             ->join('detalle_venta as dv','v.idventa','=','dv.idventa')
             ->select('v.idventa','v.fecha_hora','p.name','ci.image','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.notas','v.estado','v.total_venta','v.ordenq')
             ->where('v.idventa','=',$id)
             ->groupBy('v.idventa','v.fecha_hora','p.name','ci.image','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado')
             ->first();

        $detalles = DB::table('detalle_venta as d')
          ->join('products as a','d.id_articulo','=','a.id')
          ->select('a.name as articulo','a.description','d.cantidad','d.preciov','d.descuento','d.etiqueta')
          ->where('d.idventa','=',$id)
          ->get();
            

        $pdf = PDF::loadView('ventas.venta.pdf.imprimeordensalida', compact('venta','detalles'));

        return $pdf->download('imprimeordensalida.pdf');
    }


    public function destroy($id)
    {
    	$venta  = Venta::findOrFail($id);
    	$venta->estado = 'C';
    	$venta->update();
    	return Redirect::to('ventas/venta');
    }
}

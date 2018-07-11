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
use App\almproducts;
use App\Client;
Use Auth;

Use DB;

Use Carbon\Carbon;
Use Response;
Use Illuminate\Support\Collection;
Use Barryvdh\DomPDF\Facade as PDF;

class IngresoController extends Controller
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
    		$ingresos = DB::table('ingreso as i')
    		 ->join('clients as p','i.idproveedor','=','p.id')
    		 ->join('companies as c','i.id_empresa','=','c.id')
    		 ->join('detalle_ingreso as di','i.idingreso','=','di.idingreso')
    		 ->select('i.idingreso','i.fecha_hora','p.name','c.name as compan','i.tipo_comprobante','i.serie_comprobante','i.num_comprobante','i.impuesto','i.estado','i.notas',DB::raw('sum(di.cantidad*precioc) as total'))
             ->where('i.num_comprobante','LIKE','%'.$query.'%')
             ->where('i.id_empresa',$iu)
    		 ->orderBy('i.idingreso','desc')
    		 ->groupBy('i.idingreso','i.fecha_hora','p.name','i.tipo_comprobante','i.serie_comprobante','i.num_comprobante','i.impuesto','i.estado')
    		 ->paginate(7);
    		 return view('compras.ingreso.index',["ingresos" => $ingresos, "searchText" => $query]);
    	}

    }

    public function create()
    {
        $iu = Auth::user()->empresa_id;

    	//$clientes = DB::table('clients')->where('tipo_persona','=','Proveedor')->get();
    	$clientes =  DB::table('clients')->where('es_proveedor','=','1')->get();
    	$units =  DB::table('units')->get();
    	$articulos = DB::table('products as art')
    	  ->select(DB::raw('CONCAT(art.name," ",art.description) AS articulo'), 'art.id','art.name','art.id_unidad_prod','art.cantidad_prod')
    	  ->where('art.activo','=','1')
    	  ->get();


        // Se obtiene el cunsecutivo de Orden de Ingreso para que sea automatico...
        // algebra relacional para calcularlo...
        $no_ordeni = DB::table('ingreso')
        ->join('companies','ingreso.id_empresa','=','companies.id')
        ->select('ingreso.id_empresa', DB::raw('CONCAT(UPPER(SUBSTRING(companies.name,1,3)),"-PO-",DATE_FORMAT(NOW( ), "%H%i%S" )) as orden'), DB::raw('if(ingreso.num_comprobante REGEXP "^[0-9]"=1, CAST(ingreso.num_comprobante AS UNSIGNED) + 1 , CAST(substr(ingreso.num_comprobante,3,10) AS UNSIGNED) + 1) as nocompi'), DB::raw('CAST(ingreso.num_comprobante AS UNSIGNED) as num_comprobante'))
        ->where('ingreso.id_empresa','=',$iu)
        ->orderBy('num_comprobante','DESC')
        ->first();


        $ordeni='';
        $ncompi='';

        if ($no_ordeni){
            $ordeni=$no_ordeni->orden;
            $ncompi=$no_ordeni->nocompi;
        }else {
            $comp = DB::table('companies')
            ->select(DB::raw('CONCAT(UPPER(SUBSTRING(companies.name,1,3)),"-PO-",DATE_FORMAT(NOW( ), "%H%i%S" )) as orden'))
            ->where('companies.id','=',$iu)
            ->first();
            $ordeni=$comp->orden;
            $ncompi=1;
        }

        $fecha_actual=Carbon::now()->format('m/d/Y');

        ////////////////////////////////////////////////////////////////////////

    	return view('compras.ingreso.create',["clientes" => $clientes, "products" => $articulos, "units" => $units, "noi" => $ordeni,"nci" => $ncompi]);
    }

    public function store(IngresoFormRequest $request)
    {
    	try{

            $u  = Auth::user()->id;
            $iu = Auth::user()->empresa_id; 

    		DB::beginTransaction();


    		$ingreso = new Ingreso;
    		$ingreso->idproveedor 		= $request->get('idproveedor');
    		$ingreso->id_empresa 		= $iu;
            $ingreso->id_user           = $u;
    		$ingreso->tipo_comprobante 	= $request->get('tipo_comprobante');
    		$ingreso->serie_comprobante	= $request->get('serie_comprobante');
    		$ingreso->num_comprobante 	= $request->get('num_comprobante');
    		$mytime						= Carbon::now('America/Tijuana');
    		$ingreso->fecha_hora		= $mytime->toDateTimeString();
    		$ingreso->impuesto			= $request->get('impuesto');
    		$ingreso->estado			= 'A';
            $ingreso->notas             = $request->get('notas');
    		$ingreso->save();

    		$id_articulo 				= $request->get('id_articulo');
    		$cantidad 					= $request->get('cantidad');
    		$precioc	 				= $request->get('precioc');
            $unidad_prod                = $request->get('unidad_prod');
            $cantidad_prod              = $request->get('cantidad_prod');


    		$etiqueta					= $request->get('etiqueta');
    		
    		$cont = 0;

    		while ($cont < count($id_articulo)){
    			$detalle = new DetalleIngreso();
    			$detalle->idingreso  	     = $ingreso->idingreso;
                $detalle->id_articulo 	     = $id_articulo[$cont];
    			$detalle->cantidad 		     = $cantidad[$cont];
    			$detalle->precioc 		     = $precioc[$cont];
    			$detalle->etiqueta 		     = $etiqueta[$cont];
                //$detalle->id_unidad_prod     = $unidad_prod[$cont];
                //$detalle->cantidad_prod      = $cantidad_prod[$cont];
    			$detalle->save();

                
                //$cantproductos = almproducts::where('id_product',$id_articulo[$cont])->count();
                $cantproductos = almproducts::where([['id_product', '=', $id_articulo[$cont]],
                                                    ['etiqueta', '=', $etiqueta[$cont]],
                                                    ['id_company', '=', $ingreso->id_empresa],
                ])->count();
                
    


                if ($cantproductos > 0){
                    //$productos = almproducts::find($id_articulo[$cont]);
                    $productos = almproducts::where([['id_product', '=', $id_articulo[$cont]],
                                                    ['etiqueta', '=', $etiqueta[$cont]],
                                                    ['id_company', '=', $ingreso->id_empresa],
                ])->first();
                    $exis=$productos->existencia;
                    //dd($productos->all());

                    
                    $productos->existencia    = $exis+$cantidad[$cont];
                    //$productos->precioc       = $precioc[$cont];
                    $productos->save(); 
                }
                else {
                    $productos = new almproducts();
                    $productos->id_company    = $ingreso->id_empresa;
                    $productos->id_product    = $id_articulo[$cont];
                    $productos->existencia    = $cantidad[$cont];
                    $productos->precioc       = $precioc[$cont];
                    $productos->preciov       = '0';
                    $productos->id_unidad_prod= $unidad_prod[$cont];
                    $productos->cantidad_prod = $cantidad_prod[$cont];
                    $productos->etiqueta      = $etiqueta[$cont];
                    $productos->save();
                }


    			$cont = $cont + 1;

    		}
    		  
    		DB::commit();
            Session::flash('message','Se ha realizado exitosamente la insercion de la orden de compra');
            return redirect('/compras/ingreso')->with('status', 'exito');;


    	}catch(\Exception $e)
    	{
            //return $e;
            
            DB::rollback();
            Session::flash('message','Ha ocurrido un error...');
            return redirect('/compras/ingreso');

    	}

    	return Redirect::to('compras/ingreso')->with('status', 'noexito');
    }

    public function show($id)
    {
    	$ingreso = DB::table('ingreso as i')
    		 ->join('clients as p','i.idproveedor','=','p.id')
             ->join('client_images as ci','i.idproveedor','=','ci.client_id')
    		 ->join('detalle_ingreso as di','i.idingreso','=','di.idingreso')
    		 ->select('i.idingreso','i.fecha_hora','p.name','ci.image','i.tipo_comprobante','i.serie_comprobante','i.num_comprobante','i.impuesto','i.estado','i.notas',DB::raw('sum(di.cantidad*precioc) as total'))
    		 ->where('i.idingreso','=',$id)
             ->groupBy('i.idingreso','i.fecha_hora','p.name','ci.image','i.tipo_comprobante','i.serie_comprobante','i.num_comprobante','i.impuesto','i.estado')
    		 ->first();

    	$detalles = DB::table('detalle_ingreso as d')
    	  ->join('products as a','d.id_articulo','=','a.id')
    	  ->select('a.name as articulo','a.description','d.cantidad','d.precioc','d.etiqueta')
    	  ->where('d.idingreso','=',$id)
    	  ->get();

    	return view('compras.ingreso.show',["ingreso"=>$ingreso,"detalles"=>$detalles]);
    }

    public function pdf($id)
    {        
        if ($id<=0 )
            $id=4;

        $ingreso = DB::table('ingreso as i')
             ->join('clients as p','i.idproveedor','=','p.id')
             ->join('client_images as ci','i.idproveedor','=','ci.client_id')
             ->join('detalle_ingreso as di','i.idingreso','=','di.idingreso')
             ->select('i.idingreso','i.fecha_hora','p.name','ci.image','i.tipo_comprobante','i.serie_comprobante','i.num_comprobante','i.impuesto','i.estado','i.notas',DB::raw('sum(di.cantidad*precioc) as total'))
             ->where('i.idingreso','=',$id)
             ->groupBy('i.idingreso','i.fecha_hora','p.name','ci.image','i.tipo_comprobante','i.serie_comprobante','i.num_comprobante','i.impuesto','i.estado')
             ->first();

        $detalles = DB::table('detalle_ingreso as d')
          ->join('products as a','d.id_articulo','=','a.id')
          ->select('a.name as articulo','a.description','d.cantidad','d.precioc','d.etiqueta')
          ->where('d.idingreso','=',$id)
          ->get();
            

        $pdf = PDF::loadView('compras.ingreso.pdf.imprimeordeningreso', compact('ingreso','detalles'));

        return $pdf->download('imprimeordeningreso.pdf');
    }



    public function destroy($id)
    {
    	$ingreso  = Ingreso::findOrFail($id);
    	$ingreso->estado = 'C';
    	$ingreso->update();
    	return Redirect::to('compras/ingreso');
    }
}

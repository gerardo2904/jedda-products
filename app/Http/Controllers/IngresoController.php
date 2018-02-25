<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use Session;
Use Redirect;
Use Input;
Use App\Ingreso;
Use App\DetalleIngreso;
use App\Http\Request\IngresoFormRequest;
use DB;

use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;

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
    		 ->join('detalle_ingreso as di','i.idingreso','=','di.idingreso')
    		 ->select('i.idingreso','i.fecha_hora','p.name','i.tipo_comprobante','i.serie_comprobante','i.num_comprobante','i.impuesto','i.estado',DB::raw('sum(di.cantidad*precioc) as total'))
    		 ->where('i.num_comprobante','LIKE','%'.$query.'%')
    		 ->orderBy('i.idingreso','desc')
    		 ->groupBy('i.idingreso','i.fecha_hora','p.name','i.tipo_comprobante','i.serie_comprobante','i.num_comprobante','i.impuesto','i.estado')
    		 ->paginate(7);
    		 return view('compras.ingreso.index',["ingresos" => $ingresos, "searchText" => $query])
    	}

    }

    public function create()
    {
    	//$clientes = DB::table('clients')->where('tipo_persona','=','Proveedor')->get();
    	$clientes =  DB::table('clients')->get();
    	$articulos = DB::table('products' as art)
    	  ->select(DB::raw('CONCAT(art.name," ",art.description) AS articulo'), 'art.id')
    	  ->where('art.activo','=','1')
    	  ->get();
    	return view('compras.ingreso.create',["clients" => $clientes, "products" => $articulos]);
    }
}

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
use App\almproducts_tempo;
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
    	  ->select(DB::raw('CONCAT(art.name," ",art.description," ",ap.etiqueta) AS articulo'), 'art.id','ap.id_product','art.name','art.ancho_prod','ap.cantidad_prod','art.formula','ap.existencia','ap.etiqueta','un.name as unidad', 'un.id as id_unidad','ap.precioc','ap.preciov')
    	  ->where('art.activo','=','1')
    	  ->where('ap.id_company','=',$iu)
    	  ->where('ap.existencia','>','0')
    	  ->where('art.roll_id','=','2')  // Es materia prima
    	  ->groupBy('articulo','art.id','ap.etiqueta', 'ap.existencia', 'ap.cantidad_prod', 'unidad','precioc','preciov')
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
    	  ->select(DB::raw('CONCAT(art.name," ",art.description," ",ap.etiqueta) AS articulo'), 'art.id','ap.id_product','art.name','art.ancho_prod','ap.cantidad_prod','art.formula','ap.existencia','ap.etiqueta','ap.existencia','un.name as unidad','un.id as id_unidad','ap.precioc','ap.preciov')
    	  ->where('art.activo','=','1')
    	  ->where('ap.id_company','=',$iu)
    	  ->where('ap.existencia','>','0')
    	  ->where('art.roll_id','=','4')  // Es Leader
    	  ->groupBy('articulo','art.id','ap.etiqueta', 'ap.existencia','ap.cantidad_prod','unidad','precioc','preciov')
    	  ->get();

    	$core = DB::table('products as art')
    	->join('almproducts as ap','ap.id_product','=','art.id')
    	->join('units as un','art.id_unidad_prod','=','un.id')
    	  ->select(DB::raw('CONCAT(art.name," ",art.description," ",ap.etiqueta) AS articulo'), 'art.id','ap.id_product','art.name','art.ancho_prod','ap.cantidad_prod','art.formula','ap.existencia','ap.etiqueta','ap.existencia','un.name as unidad','un.id as id_unidad','ap.precioc','ap.preciov')
    	  ->where('art.activo','=','1')
    	  ->where('ap.id_company','=',$iu)
    	  ->where('ap.existencia','>','0')
    	  ->where('art.roll_id','=','3')  // Es core
    	  ->groupBy('articulo','art.id','ap.etiqueta', 'ap.existencia','ap.cantidad_prod', 'unidad','precioc','preciov')
    	  ->get();

    	$sticker = DB::table('products as art')
    	->join('almproducts as ap','ap.id_product','=','art.id')
    	->join('units as un','art.id_unidad_prod','=','un.id')
    	  ->select(DB::raw('CONCAT(art.name," ",art.description," ",ap.etiqueta) AS articulo'), 'art.id','ap.id_product','art.name','art.ancho_prod','ap.cantidad_prod','art.formula','ap.existencia','ap.etiqueta','ap.existencia','un.name as unidad','un.id as id_unidad','ap.precioc','ap.preciov')
    	  ->where('art.activo','=','1')
    	  ->where('ap.id_company','=',$iu)
    	  ->where('ap.existencia','>','0')
    	  ->where('art.roll_id','=','5')  // Es Sticker
    	  ->groupBy('articulo','art.id','ap.etiqueta', 'ap.existencia','ap.cantidad_prod','unidad','precioc','preciov')
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


            $corrida                                =   0;
            $id_producto_pt                         =   $request->get('id_producto_pt');
            //$id_etiqueta_pt                         =   $request->get('etiqueta_pt');
            $cantidad_pt                            =   $request->get('cantidad_pt');
            // $u es el usuario
            $estado_pt                              =   0;

            $cont = 0;

            while ($cont < count($id_producto_pt)){
                $detalle = new Detalle_Production_Order();
                $detalle->id_production     =   $ordenproduccion->id_production; //$ordenproduccion->orden;
                $detalle->corrida           =   $corrida;
                $detalle->id_producto_pt    =   $id_producto_pt[$cont];
                $detalle->etiqueta_pt       =   $ordenproduccion->etiqueta_mp;
                $detalle->cantidad_pt       =   $cantidad_pt[$cont];
                $detalle->id_user           =   $u;
                $detalle->estado_pt         =   $estado_pt;
                
                $detalle->save();
                $cont = $cont + 1;
            }

            $corrida                                =   0;
            $id_producto_pt                         =   $request->get('id_producto_pt2');
            //$id_etiqueta_pt                         =   $request->get('etiqueta_pt2');
            $cantidad_pt                            =   $request->get('cantidad_pt2');
            // $u es el usuario
            $estado_pt                              =   0;

            $cont = 0;

            while ($cont < count($id_producto_pt)){
                $detalle2 = new Detalle_Production_Order();
                $detalle2->id_production     =   $ordenproduccion->id_production; //$ordenproduccion->orden;
                $detalle2->corrida           =   $corrida;
                $detalle2->id_producto_pt    =   $id_producto_pt[$cont];
                $detalle2->etiqueta_pt       =   $ordenproduccion->etiqueta_mp;
                $detalle2->cantidad_pt       =   $cantidad_pt[$cont];
                $detalle2->id_user           =   $u;
                $detalle2->estado_pt         =   $estado_pt;
                
                $detalle2->save();
                $cont = $cont + 1;
            }

            // Se pasa la materia prima a tabla temporal
            $alm_mp = new almproducts_tempo();
            $alm_mp->id_production            =   $ordenproduccion->id_production;
            $alm_mp->id_company               =   $iu;
            $alm_mp->id_product               =   $request->get('tempo_id_producto_mp');  
            $alm_mp->existencia               =   1;
            $alm_mp->precioc                  =   $request->get('tempo_precioc_mp');
            $alm_mp->preciov                  =   $request->get('tempo_preciov_mp');
            $alm_mp->id_unidad_prod           =   $request->get('tempo_id_unidad_mp');
            $alm_mp->cantidad_prod            =   $request->get('largo_mp'); 
            $alm_mp->ncantidad_prod           =   $request->get('total_largo_restante'); 
            $alm_mp->etiqueta                 =   $request->get('etiqueta_mp');
            $alm_mp->save();

            // Se pasa el core a tabla temporal
            $alm_core = new almproducts_tempo();
            $alm_core->id_production            =   $ordenproduccion->id_production;
            $alm_core->id_company               =   $iu;
            $alm_core->id_product               =   $request->get('tempo_id_producto_core');  
            $alm_core->existencia               =   1;
            $alm_core->precioc                  =   $request->get('tempo_precioc_core');
            $alm_core->preciov                  =   $request->get('tempo_preciov_core');
            $alm_core->id_unidad_prod           =   $request->get('tempo_id_unidad_core');
            $alm_core->cantidad_prod            =   $request->get('cantidad_core'); 
            $alm_core->ncantidad_prod           =   $request->get('cantidad_core_restante'); 
            $alm_core->etiqueta                 =   $request->get('etiqueta_core');
            $alm_core->save();

            // Se pasa el leader 1 a tabla temporal
            $alm_leader1 = new almproducts_tempo();
            $alm_leader1->id_production            =   $ordenproduccion->id_production;
            $alm_leader1->id_company               =   $iu;
            $alm_leader1->id_product               =   $request->get('tempo_id_producto_leader1');  
            $alm_leader1->existencia               =   1;
            $alm_leader1->precioc                  =   $request->get('tempo_precioc_leader1');
            $alm_leader1->preciov                  =   $request->get('tempo_preciov_leader1');
            $alm_leader1->id_unidad_prod           =   $request->get('tempo_id_unidad_leader1');
            $alm_leader1->cantidad_prod            =   $request->get('largo_leader1'); 
            $alm_leader1->ncantidad_prod           =   $request->get('largo_leader1_restante');
            $alm_leader1->etiqueta                 =   $request->get('etiqueta_leader1');
            $alm_leader1->save();

            // Se pasa el leader 2 a tabla temporal
            $alm_leader2 = new almproducts_tempo();
            $alm_leader2->id_production            =   $ordenproduccion->id_production;
            $alm_leader2->id_company               =   $iu;
            $alm_leader2->id_product               =   $request->get('tempo_id_producto_leader2');  
            $alm_leader2->existencia               =   1;
            $alm_leader2->precioc                  =   $request->get('tempo_precioc_leader2');
            $alm_leader2->preciov                  =   $request->get('tempo_preciov_leader2');
            $alm_leader2->id_unidad_prod           =   $request->get('tempo_id_unidad_leader2');
            $alm_leader2->cantidad_prod            =   $request->get('largo_leader2'); 
            $alm_leader2->ncantidad_prod           =   $request->get('largo_leader2_restante');
            $alm_leader2->etiqueta                 =   $request->get('etiqueta_leader2');
            $alm_leader2->save();

            // Se pasa el leader 3 a tabla temporal
            $alm_leader3 = new almproducts_tempo();
            $alm_leader3->id_production            =   $ordenproduccion->id_production;
            $alm_leader3->id_company               =   $iu;
            $alm_leader3->id_product               =   $request->get('tempo_id_producto_leader3');  
            $alm_leader3->existencia               =   1;
            $alm_leader3->precioc                  =   $request->get('tempo_precioc_leader3');
            $alm_leader3->preciov                  =   $request->get('tempo_preciov_leader3');
            $alm_leader3->id_unidad_prod           =   $request->get('tempo_id_unidad_leader3');
            $alm_leader3->cantidad_prod            =   $request->get('largo_leader3'); 
            $alm_leader3->ncantidad_prod           =   $request->get('largo_leader3_restante'); 
            $alm_leader3->etiqueta                 =   $request->get('etiqueta_leader3');
            $alm_leader3->save();

            // Se pasa las etiquetas a tabla temporal
            $alm_etiqueta = new almproducts_tempo();
            $alm_etiqueta->id_production            =   $ordenproduccion->id_production;
            $alm_etiqueta->id_company               =   $iu;
            $alm_etiqueta->id_product               =   $request->get('tempo_id_producto_sticker');  
            $alm_etiqueta->existencia               =   1;
            $alm_etiqueta->precioc                  =   $request->get('tempo_precioc_sticker');
            $alm_etiqueta->preciov                  =   $request->get('tempo_preciov_sticker');
            $alm_etiqueta->id_unidad_prod           =   $request->get('tempo_id_unidad_sticker');
            $alm_etiqueta->cantidad_prod            =   $request->get('cantidad_sticker'); 
            $alm_etiqueta->ncantidad_prod           =   $request->get('cantidad_sticker_restante'); 
            $alm_etiqueta->etiqueta                 =   $request->get('etiqueta_sticker');
            $alm_etiqueta->save();

            // Se dan de baja las materias prima del almacen...
            $x=$request->get('tempo_id_producto_mp');
            $y=$request->get('etiqueta_mp');
            

            $ms = DB::table('almproducts as art')
            ->select('id','id_company','id_product','existencia','precioc','preciov','id_unidad_prod','cantidad_prod','etiqueta')
            ->where('art.id_product','=',$x)
            ->where('art.id_company','=',$iu)
            ->where('art.etiqueta','=',$y)
            ->where('art.existencia','>','0')
            ->limit(1)
            ->first();
       
            if ($ms){
                if($ms->existencia>0){
                    $ex=$ms->existencia-1;
                    $msx = almproducts::find($ms->id);
                    $msx->existencia = $ex;
                    $msx->save();
                }
            }
            // Fin de las bajas de materia prima...

            // Se dan de baja el core del almacen...
            $x=$request->get('tempo_id_producto_core');
            $y=$request->get('etiqueta_core');

            $ms = DB::table('almproducts as art')
            ->select('id','id_company','id_product','existencia','precioc','preciov','id_unidad_prod','cantidad_prod','etiqueta')
            ->where('art.id_product','=',$x)
            ->where('art.id_company','=',$iu)
            ->where('art.etiqueta','=',$y)
            ->where('art.existencia','>','0')
            ->limit(1)
            ->first();
       
            if ($ms){
                if($ms->existencia>0){
                    $ex=$ms->existencia-1;
                    $msx = almproducts::find($ms->id);
                    $msx->existencia = $ex;
                    $msx->save();
                }
            }
            // Fin de las bajas de core...           

            // Se dan de baja el leader 1 del almacen...
            $x=$request->get('tempo_id_producto_leader1');
            $y=$request->get('etiqueta_leader1');

            $ms = DB::table('almproducts as art')
            ->select('id','id_company','id_product','existencia','precioc','preciov','id_unidad_prod','cantidad_prod','etiqueta')
            ->where('art.id_product','=',$x)
            ->where('art.id_company','=',$iu)
            ->where('art.etiqueta','=',$y)
            ->where('art.existencia','>','0')
            ->limit(1)
            ->first();
       
            if ($ms){
                if($ms->existencia>0){
                    $ex=$ms->existencia-1;
                    $msx = almproducts::find($ms->id);
                    $msx->existencia = $ex;
                    $msx->save();
                }
            }
            // Fin de las bajas de leader 1...           

            // Se dan de baja el leader 2 del almacen...
            $x=$request->get('tempo_id_producto_leader2');
            $y=$request->get('etiqueta_leader2');
            
            $ms = DB::table('almproducts as art')
            ->select('id','id_company','id_product','existencia','precioc','preciov','id_unidad_prod','cantidad_prod','etiqueta')
            ->where('art.id_product','=',$x)
            ->where('art.id_company','=',$iu)
            ->where('art.etiqueta','=',$y)
            ->where('art.existencia','>','0')
            ->limit(1)
            ->first();
       
            if ($ms){
                if($ms->existencia>0){
                    $ex=$ms->existencia-1;
                    $msx = almproducts::find($ms->id);
                    $msx->existencia = $ex;
                    $msx->save();
                }
            }
            // Fin de las bajas de leader 2...           

            // Se dan de baja el leader 3 del almacen...
            $x=$request->get('tempo_id_producto_leader3');
            $y=$request->get('etiqueta_leader3');

            $ms = DB::table('almproducts as art')
            ->select('id','id_company','id_product','existencia','precioc','preciov','id_unidad_prod','cantidad_prod','etiqueta')
            ->where('art.id_product','=',$x)
            ->where('art.id_company','=',$iu)
            ->where('art.etiqueta','=',$y)
            ->where('art.existencia','>','0')
            ->limit(1)
            ->first();
       
            if ($ms){
                if($ms->existencia>0){
                    $ex=$ms->existencia-1;
                    $msx = almproducts::find($ms->id);
                    $msx->existencia = $ex;
                    $msx->save();
                }
            }
            // Fin de las bajas de leader 3...           

            // Se dan de baja el sticker del almacen...
            $x=$request->get('tempo_id_producto_sticker');
            $y=$request->get('etiqueta_sticker');

            $ms = DB::table('almproducts as art')
            ->select('id','id_company','id_product','existencia','precioc','preciov','id_unidad_prod','cantidad_prod','etiqueta')
            ->where('art.id_product','=',$x)
            ->where('art.id_company','=',$iu)
            ->where('art.etiqueta','=',$y)
            ->where('art.existencia','>','0')
            ->limit(1)
            ->first();
       
            if ($ms){
                if($ms->existencia>0){
                    $ex=$ms->existencia-1;
                    $msx = almproducts::find($ms->id);
                    $msx->existencia = $ex;
                    $msx->save();
                }
            }
            // Fin de las bajas de sticker... 


            // Ahora, se pasaran los productos de materias prima de la tabla almproducts_tempo
            // a la tabla almproducts ya como productos diferentes (con nuevas medidas).

            $aptempo = DB::table('almproducts_tempo')
            ->select('id','id_company','id_product','existencia','precioc','preciov','id_unidad_prod','ncantidad_prod','etiqueta')
            ->where('id_production','=',$ordenproduccion->id_production)
            ->get();

            foreach($aptempo as $t){
                $tid_company        = $t->id_company;
                $tid_product        = $t->id_product;
                $texistencia        = $t->existencia;
                $tprecioc           = $t->precioc;
                $tpreciov           = $t->preciov;
                $tid_unidad_prod    = $t->id_unidad_prod;
                $tncantidad_prod    = $t->ncantidad_prod;
                $tetiqueta          = $t->etiqueta;

                $almpt = new almproducts();
                $almpt->id_company      =   $tid_company;
                $almpt->id_product      =   $tid_product;
                $almpt->existencia      =   $texistencia;
                $almpt->precioc         =   $tprecioc;
                $almpt->preciov         =   $tpreciov;
                $almpt->id_unidad_prod  =   $tid_unidad_prod;
                $almpt->cantidad_prod   =   $tncantidad_prod;
                $almpt->etiqueta        =   $tetiqueta;
                $almpt->save();
            }

            $dptempo = DB::table('detalle_production_order as dart')
            ->join('products as p','p.id','=','dart.id_producto_pt')
            ->join('units as un','p.id_unidad_prod','=','un.id')
            ->select('dart.id_production','dart.id_producto_pt as id_product','dart.etiqueta_pt as etiqueta','dart.cantidad_pt as existencia','un.id as unidad_produccion','p.ancho_prod')
            ->where('dart.id_production','=',$ordenproduccion->id_production)
            ->groupBy('dart.id_producto_pt','dart.id_production','dart.etiqueta_pt','un.id','p.ancho_prod','existencia')
            ->get();

            foreach($dptempo as $t){
                $tid_company        = $iu;
                $tid_product        = $t->id_product;
                $texistencia        = $t->existencia;
                $tprecioc           = 0;
                $tpreciov           = 0;
                $tid_unidad_prod    = $t->unidad_produccion;
                $tncantidad_prod    = $t->ancho_prod;
                $tetiqueta          = $t->etiqueta;

                $almpt = new almproducts();
                $almpt->id_company      =   $tid_company;
                $almpt->id_product      =   $tid_product;
                $almpt->existencia      =   $texistencia;
                $almpt->precioc         =   $tprecioc;
                $almpt->preciov         =   $tpreciov;
                $almpt->id_unidad_prod  =   $tid_unidad_prod;
                $almpt->cantidad_prod   =   $tncantidad_prod;
                $almpt->etiqueta        =   $tetiqueta;
                $almpt->save();
            }

            

            



            // Fin de copia de almproducts_tempo a almproducts



    		DB::commit();
            Session::flash('message','Se ha realizado exitosamente la insercion de la orden de producción');
            return redirect('/productionorder/production')->with('status', 'exito');


    	}catch(\Exception $e)
    	{
            return $e;
            
            DB::rollback();
            Session::flash('message',$msj);
            return redirect('/productionorder/production')->with('status', 'noexito');

    	}

    	return Redirect::to('productionorder/production')->with('status', 'noexito');
    }


    public function show($id)
    {
        
    	$productionorder = DB::table('production_order as po')
    		 ->join('clients as p','po.idcliente','=','p.id')
             ->join('client_images as ci','po.idcliente','=','ci.client_id')
             ->join('detalle_production_order as dpo','po.id_production','=','dpo.id_production')
             ->join('products as p1','po.id_producto_mp','=','p1.id')
    		 ->select('po.id_production','po.direction as direccion','po.orden','po.fecha_hora', 'po.orden_cliente', 'po.fecha_hora','p.name', DB::raw('CONCAT(p.address, ", CP ", p.cp, " ",p.city) as direction'), 'ci.image','po.estado',DB::raw('CONCAT(p1.name, " ", p1.description) as name_materiaprima'),'p1.formula','po.etiqueta_mp')
    		 ->where('po.id_production','=',$id)
             ->groupBy('po.id_production','po.fecha_hora','p.name','ci.image','po.estado')
    		 ->first();

    	$detalles = DB::table('detalle_production_order as dpo')
    	  ->join('products as a','dpo.id_producto_pt','=','a.id')
    	  ->select('a.name as articulo','a.description','a.ancho_prod', 'a.cantidad_prod', 'dpo.cantidad_pt','dpo.etiqueta_pt')
    	  ->where('dpo.id_production','=',$id)
    	  ->get();

          $leader= DB::table('production_order as po')
             ->join('products as leader1','po.id_producto_leader1','=','leader1.id')
             ->join('products as leader2','po.id_producto_leader2','=','leader2.id')
             ->join('products as leader3','po.id_producto_leader3','=','leader3.id')
             ->select('po.id_production',DB::raw('CONCAT(leader1.name, " ", leader1.description) as name_leader1'),'po.etiqueta_leader1',DB::raw('CONCAT(leader2.name, " ", leader2.description) as name_leader2'),'po.etiqueta_leader2',DB::raw('CONCAT(leader3.name, " ", leader3.description) as name_leader3'),'po.etiqueta_leader3')
             ->where('po.id_production','=',$id)
             ->groupBy('po.id_production','po.fecha_hora','leader1.name','leader2.name','leader3.name')
             ->first();

    	
        return view('productionorder.production.show',["productionorder"=>$productionorder,"detalles"=>$detalles,"leader"=>$leader]);
    }

    public function destroy($id)
    {
    	$productionorder  = Production_Order::findOrFail($id);
    	$productionorder->estado = 'C';
    	$productionorder->update();
    	return Redirect::to('productionorder/production');
    }
}

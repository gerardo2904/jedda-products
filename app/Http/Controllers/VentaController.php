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


    	return view('ventas.venta.create',["clientes" => $clientes, "products" => $articulos, "units" => $units, "nov" => $ordenv,"ncv" => $ncompv,"estado" =>"A"]);
    }

    public function store(VentaFormRequest $request)
    {
    	try{
            $msj="Ha ocurrido un error...";

			$u  = Auth::user()->id;
			$iu = Auth::user()->empresa_id; 

            $estado=$request->get('estado');

            if (!$estado=="F"){
                $estado="A";
            }
			

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
    		$venta->estado				= $estado;
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

                    $productos->preciov       = $preciov[$cont];
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


    public function edit($id)
    {
        //$clientes = DB::table('clients')->where('tipo_persona','=','Proveedor')->get();

        $iu = Auth::user()->empresa_id; 

        $ordenv=$id;


        $clientes =  DB::table('clients')->where('es_proveedor','=','0')->get();

        $units =  DB::table('units')->get();

        $articulos = DB::table('products as art')
        ->join('almproducts as ap','ap.id_product','=','art.id')
          ->select(DB::raw('CONCAT(art.name," ",art.description) AS articulo'), 'art.id','ap.id_product','ap.etiqueta','art.name','ap.preciov','ap.existencia','art.id_unidad_prod','art.cantidad_prod')
          ->where('art.activo','=','1')
          ->where('ap.id_company','=',$iu)
          ->where('ap.existencia','>','0')
          ->groupBy('art.id','art.name','art.description','ap.etiqueta','ap.preciov', 'ap.existencia')
          ->get();



         $venta = DB::table('venta as v')
             ->join('clients as p','v.idcliente','=','p.id')
             ->join('client_images as ci','v.idcliente','=','ci.client_id')
             ->join('detalle_venta as dv','v.idventa','=','dv.idventa')
             ->select('v.idventa','v.fecha_hora','p.name','ci.image','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado','v.ordenq','v.notas',DB::raw('sum(dv.cantidad*preciov) as total'))
             ->where('v.idventa','=',$ordenv)
             ->groupBy('v.idventa','v.fecha_hora','p.name','ci.image','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado')
             ->first();

        $detalles = DB::table('detalle_venta as d')
          ->join('products as a','d.id_articulo','=','a.id')
          ->select('a.name as articulo','a.description','d.id_articulo','d.cantidad','d.preciov','d.etiqueta','a.id_unidad_prod', 'a.cantidad_prod')
          ->where('d.idventa','=',$ordenv)
          ->get();

        return view('ventas.venta.edit',["venta"=>$venta,"detalles"=>$detalles, "clientes" => $clientes, "products" => $articulos, "units" => $units, "nov" => $ordenv]);

    }

    public function update(Request $request, $id)
    {
        try{

            $u  = Auth::user()->id;
            $iu = Auth::user()->empresa_id; 

            $estado=$request->get('estado');

            if (!$estado=="F"){
                $estado="A";
            }


            DB::beginTransaction();


            $venta = Venta::find($id);

            $venta->idcliente           = $request->get('idcliente');
            $venta->id_empresa          = $iu;
            $venta->id_user             = $u;
            $venta->tipo_comprobante    = $request->get('tipo_comprobante');
            $venta->ordenq              = $request->get('ordenq');
            $venta->total_venta         = $request->get('total_venta');
            $mytime                     = Carbon::now('America/Tijuana');
            $venta->fecha_hora          = $mytime->toDateTimeString();
            $venta->impuesto            = $request->get('impuesto');
            $venta->estado              = $estado;
            $venta->notas               = $request->get('notas');
            $venta->save();

            $id_articulo                = $request->get('id_articulo');
            $cantidad                   = $request->get('cantidad');
            $preciov                    = $request->get('preciov');
            $descuento                  = $request->get('descuento');
            $etiqueta                   = $request->get('etiqueta');
            
            
            $cont = 0;

            

            $numero_articulos_array = count($id_articulo);
            $numero_articulos_tabla = DetalleVenta::where([['idventa', '=', $id]])->count();
            $men=" ";

            if($numero_articulos_array == $numero_articulos_tabla){
                // Si si, posiblemente no cambio nada, se verifica y si todo esta igual
                // no se modifican los articulos previamente capturados.
                if ($this->verificaArticulos($id, $request, $numero_articulos_array)){
                    //Se puede proseguir a grabar algun cambio en la caratula de la orden
                    // o a finalizarla.
                    $men="Actualización exitosa";
                    
                }else {
                    
                    $id_articulox                = $request->get('id_articulo');
                    $cantidadx                   = $request->get('cantidad');
                    $preciovx                    = $request->get('preciov');
                    $etiquetax                   = $request->get('etiqueta');

                    $contx = 0;
                    while ($contx < $numero_articulos_array){
                        $productosx = DetalleVenta::where([['idventa', '=', $id], ['id_articulo', '=', $id_articulox[$contx]], ['etiqueta', '=', $etiquetax[$contx]]])->count();

                    if($productosx<>1){
                        ///////////////
                        $men="Actualizazión exitosa...";
                                                
                        // En esta funcion, se debe retornar un array con elementos a borrar...
                        $resparreglo=$this->verificaArrayArticulos($id, $request, $numero_articulos_array);

                        if (sizeof($resparreglo)==0) {
                            $men = "Actualizazión exitosa...";
                            //return $men;
                        }
                        else {
                            // Si cambia el contenido de la orden de salida al editarle
                            // Se actualiza mediante una comprobacion del arreglo (en memoria)
                            // con el contenido de la tabla en mysql

                            $men = "Actualizazión exitosa, aunque cambio el contenido original...";

                            $apuntador = 0;
                            while ($apuntador < sizeof($resparreglo)){
                                $campos = explode("_", $resparreglo[$apuntador]);

                                //$men=$men." id_articulo = ". $campos[0]." cantidad = ". $campos[1]." preciov = ". $campos[2]." etiqueta = ". $campos[3]."<BR>";

                                $productosDetB = DetalleVenta::where([['idventa', '=', $venta->idventa], ['id_articulo', '=', $campos[0]], ['cantidad', '=', $campos[1]], ['preciov', '=', $campos[2]], ['etiqueta', '=', $campos[3]] ])->delete();

                                $prod_almacenT = almproducts::where([['id_product', '=', $campos[0]],['etiqueta', '=', $campos[3]],['id_company', '=', $iu]])->first();

                                if ($prod_almacenT){

                                    $nuevaCantidad = $prod_almacenT->existencia + $campos[1];

                                    $prod_almacenT->existencia = $nuevaCantidad;
                                    $prod_almacenT->save();
                                }
                                $apuntador++;

                                $detallen = new DetalleVenta();
                                $detallen->idventa            = $venta->idventa;
                                $detallen->id_articulo        = $id_articulox[$contx];
                                $detallen->cantidad           = $cantidadx[$contx];
                                $detallen->preciov            = $preciovx[$contx];
                                $detallen->etiqueta           = $etiquetax[$contx];
                                $detallen->save();

                                $prod_almacenT2 = almproducts::where([['id_product', '=', $id_articulox[$contx]],['etiqueta', '=', $etiquetax[$contx]],['id_company', '=', $iu]])->first();

                                if ($prod_almacenT2){

                                    $nuevaCantidad = $prod_almacenT2->existencia - $cantidadx[$contx];

                                    $prod_almacenT2->existencia = $nuevaCantidad;
                                    $prod_almacenT2->save();
                                }


                            }
                            //return $men;
                        }
                        //return $men;

                        



                        ////////////////
                        
                    }else{
                        $productosx1 = DetalleVenta::where([['idventa', '=', $id], ['id_articulo', '=', $id_articulox[$contx]], ['etiqueta', '=', $etiquetax[$contx]]])->first();

                        //Si lo encuentra, preguntamos si son iguales las cantidades y precios de venta
                        //Si no son iguales, se actualiza inventario, si si, se deja igual...
                        if($cantidadx[$contx] == $productosx1->cantidad && $preciovx[$contx] == $productosx1->preciov) {
                            // TODO BIEN
                        }else {
                            // AQUI, SE TIENE QUE ACTUALIZAR EL INVENTARIO, ES DECIR, RESTAR LO QUE SE TIENE ACTUALMENTE 
                            // EN LA TABLE DE DETALLE_VENTA Y SUMAR LO QUE SE TIENE EN LA VARIABLE $productosx1->cantidad
                            // A SU VEZ, ACTUALIZAR EL PRECIO DE VENTA

                            $prod_almacen = almproducts::where([['id_product', '=', $id_articulox[$contx]],['etiqueta', '=', $etiquetax[$contx]],['id_company', '=', $iu]])->first();

                            $exis_almacen=$prod_almacen->existencia;
                            $preciov_almacen=$prod_almacen->preciov;

                            // SE RESTA LO QUE SE TIENE CAPTURADO EN DETALLE_VENTA
                            $nueva_existencia_almacen=0;
                            $nueva_existencia_almacen=$exis_almacen-$productosx1->cantidad;

                            // SE SUMA LO QUE SE ACABA DE CAPTURAR
                            $nueva_existencia_almacen=$nueva_existencia_almacen+$cantidadx[$contx];


                            // SE ACTUALIZA NUEVO PRECIO DE VENTA
                            $nueva_preciov_almacen=0;
                            $nueva_preciov_almacen=$preciovx[$contx];



                            //SE ACTUALIZAN CANTIDADES Y PRECIOES EN TABLA...
                            $productosx1->cantidad = $nueva_existencia_almacen;
                            $productosx1->preciov  = $nueva_preciov_almacen;
                            $productosx1->save(); 
                        }
                    }
                    $contx++;
                    }
                    $men="Actualización exitosa.";

                }

            }else{
                
                $productosActualizarDV = DetalleVenta::where([['idventa', '=', $id]])->get();

                while($productosActualizarDV){
                    $prod_almacenDV = almproducts::where([['id_product', '=', $productosActualizarDV->id_articulo],['etiqueta', '=', $productosActualizarDV->etiqueta],['id_company', '=', $iu]])->first();    
                    
                    $cantidad_temporal=$prod_almacenDV->existencia;

                    $prod_almacenDV->existencia = $cantidad_temporal - $productosActualizarDV->cantidad;
                    $prod_almacenDV->save();
                }


                $productosB = DetalleVenta::where([['idventa', '=', $id]])->delete();
                //Hay que revisar esto porque hay que regresar el numero de articulos borrados al almacen...
                ////////////////
                ///////////////

                $cont = 0;

                while ($cont < count($id_articulo)){
                    $detalle = new DetalleVenta();
                    $detalle->idventa            = $venta->idventa;
                    $detalle->id_articulo        = $id_articulo[$cont];
                    $detalle->cantidad           = $cantidad[$cont];
                    $detalle->preciov            = $preciov[$cont];
                    $detalle->etiqueta           = $etiqueta[$cont];
                    $detalle->save();

                    $prod_almacenA = almproducts::where([['id_product', '=', $id_articulo[$cont]],['etiqueta', '=', $$etiqueta[$cont]],['id_company', '=', $iu]])->first(); 

                    $cantidad_temporal=$prod_almacenA->existencia;
                    $preciov_remporal=$prod_almacenA->preciov;


                    $prod_almacenA->existencia = $cantidad_temporal+$cantidad[$cont];
                    $prod_almacenA->preciov = $preciov[$cont];
                    $prod_almacenA->save();


                    $cont++;

                     

                }

                $men="Actualización exitosa.";

            }

        
    
            DB::commit();
            Session::flash('message',$men);
            return redirect('/ventas/venta')->with('status', 'exito');;


        }catch(\Exception $e)
        {
            return $e;
            
            DB::rollback();
            Session::flash('message','Ha ocurrido un error...');
            return redirect('/ventas/venta');

        }

        return Redirect::to('ventas/venta')->with('status', 'noexito');
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

    public function verificaArticulos($id, $request, $numero_articulos_array){

        $id_articulox                = $request->get('id_articulo');
        $cantidadx                   = $request->get('cantidad');
        $preciovx                    = $request->get('preciov');
        $etiquetax                   = $request->get('etiqueta');

        $contx = 0;
        while ($contx < $numero_articulos_array){

        $productosx = DetalleVenta::where([['idventa', '=', $id], ['id_articulo', '=', $id_articulox[$contx]], ['cantidad', '=', $cantidadx[$contx]], ['preciov', '=', $preciovx[$contx]], ['etiqueta', '=', $etiquetax[$contx]]])->count();

        if($productosx<>1){
            return false;
        }
        $contx++;
        }
        return true;
    }

    public function verificaArrayArticulos($id, $request, $numero_articulos_array){

        $productosBD = DetalleVenta::where([['idventa', '=', $id]])->get();


            //dd($request);

        foreach ($productosBD as $pbd) {

            //echo $pbd->id_articulo;
            //echo "si pasa...";

            
            // Variables para manejar valored de la BD
            $id_articuloBD                = $pbd->id_articulo;
            $cantidadBD                   = $pbd->cantidad;
            $preciovBD                    = $pbd->preciov;
            $etiquetaBD                   = $pbd->etiqueta;
            
            $contador=0;
            
            $id_articuloArray                = $request->get('id_articulo');
            $cantidadArray                   = $request->get('cantidad');
            $preciovArray                    = $request->get('preciov');
            $etiquetaArray                   = $request->get('etiqueta');

            $arreglo=[];
            $apuntador=0;

            while ($contador < $numero_articulos_array){
                
                if($id_articuloBD == $id_articuloArray[$contador] && $cantidadBD == $cantidadArray[$contador] && $preciovBD == $preciovArray[$contador] && $etiquetaBD == $etiquetaArray[$contador]  ){
                    // Todo bien
                } else {
                    //Hay que borrar el articulo de la base de datos

                    // Primero, se crea un array y se retorna para borrar lo relacionado a este array...

                    $arreglo[$contador] = [
                    "id_articulo"    => $id_articuloBD,
                    "cantidad"       => $cantidadBD,
                    "preciov"      => $preciovBD,
                    "etiqueta"      => $etiquetaBD
                    ];
                    $arreglo[$contador] = implode("_",$arreglo[$contador]);
                    $apuntador++;
                }   

                $contador++;
            } 
        }

        return $arreglo;
    }


}

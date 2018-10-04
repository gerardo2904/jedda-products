@extends('layouts.app')

@section('title','Jedda')

@section('body-class', 'product-page')

@section('content')

<div class="header header-filter" style="background-image: url('/img/imagen_principal2.png');">
</div>

<div class="main main-raised">
	<div class="container">
     	<div class="section">
            <h2 class="title text-center">Editar orden de ingreso</h2>
                    
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                    
            <form method="post" name="forma" action="{{ url('compras/ingreso/'.$ingreso->idingreso.'/edit')}}">
                                                        
                {{ csrf_field() }}                       
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group label-floating">
                            <label class="control-label">Proveedor</label>
                            <select class="form-control selectpicker" name="idproveedor" id="idproveedor" data-live-search="true" data-style="btn-primary">
                                @foreach ($clientes as $cliente)
                                    <option value="{{ $cliente->id }}">{{ $cliente->name }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="id_empresa" id="id_empresa" value="{{ auth()->user()->empresa_id}}">
                        </div>
                    </div>
                </div>
                        
                <div class="row">
                    <div class="col-sm-2">
                        <div class="form-group label-floating">
                            <label class="control-label">Tipo de comprobante</label>
                            <select class="form-control" name="tipo_comprobante">
                                <option value="Factura">Factura</option>
                                <option value="Recibo">Recibo</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group label-floating">
                            <label class="control-label">Serie de comprobante</label>
                            <input type="text" readonly class="form-control" name="serie_comprobante" value="{{old('serie_comprobante',$ingreso->serie_comprobante)}}">
                        </div>
                    </div>
                        
                    <div class="col-sm-2">
                        <div class="form-group label-floating">
                            <label class="control-label">Número de comprobante</label>
                            <input type="text" readonly class="form-control" name="num_comprobante" required value="{{old('num_comprobante',$ingreso->num_comprobante)}}">
                        </div>
                    </div>

                    <div class="col-sm-1">
                        <div class="form-group label-floating">
                            <label class="control-label">Impuesto</label>
                            <input type="number" class="form-control" name="impuesto" id="impuesto" required value="{{old('impuesto',$ingreso->impuesto)}}">
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group label-floating">
                            <label class="control-label">Orden Trabajo</label>
                            <input type="text" class="form-control" name="ordenp" id="ordenp" required value="{{old('ordenp',$ingreso->ordenp)}}" onkeyup="this.value=NumText(this.value)">
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group label-floating">
                            <label class="control-label">Nota</label>
                            <input type="text" class="form-control" name="notas" id="notas" value="{{old('notas',$ingreso->notas)}}">
                        </div>
                    </div>
                </div>
                    
                <div class="row">
                    <div class="panel panel-primary">
                        <div class="panel-body">

                            <div class="col-sm-3">
                                <div class="form-group label-floating">
                                    <label class="control-label">Artículo</label>
                                    <select class="form-control selectpicker " name="pidarticulo" id="pidarticulo" data-live-search="true" data-style="btn-primary">
                                        @foreach ($products as $articulo)
                                            <option value="{{ $articulo->id }}_{{ $articulo->id_unidad_prod }}_{{ $articulo->cantidad_prod }}">{{ $articulo->articulo }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                                
                            <div class="col-sm-2">
                                <div class="form-group label-floating">
                                    <label class="control-label">Cantidad</label>
                                    <input type="number" class="form-control" name="pcantidad" id="pcantidad"  >
                                    <input type="hidden" name="pid_unidad_prod" id="pid_unidad_prod"  >
                                    <input type="hidden" name="pcantidad_prod" id="pcantidad_prod"  >
                                    <input type="hidden" name="pid_articulo" id="pid_articulo"  >
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <div class="form-group label-floating">
                                    <label class="control-label">Precio</label>
                                    <input type="number" step="0.0001" class="form-control" name="pprecioc" id="pprecioc"  >
                                </div>
                            </div>
                                
                            <div class="col-sm-2">
                                <div class="form-group label-floating">
                                    <label class="control-label">Etiqueta (lote)</label>
                                    <input type="text" class="form-control" name="petiqueta" id="petiqueta"  onkeyup="this.value=NumText(this.value)">
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group label-floating">
                                    <button type="button" id="bt_add" class="btn btn-primary">Agregar</button>
                                </div>
                            </div>

                            <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                                <div class="form-group label-floating">
                                    <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                                        <thead style="background-color:#A9D0F5">
                                            <th>Opciones</th>
                                            <th>Artículo</th>
                                            <th>Cantidad</th>
                                            <th>Precio de compra</th>
                                            <th>Etiqueta(Lote)</th>
                                            <th>Subtotal</th>
                                        </thead>
                                        <tfoot>
                                            <script type="text/javascript">
                                                var contadorJS=0;
                                                    cantidadJS=0;
                                                    precioJS=0;
                                                    totalJS=0;
                                                    taxJS=0;
                                                    subtotalJS=[];
                                                    subtotJS=0;
                                                    gtJS=0;
                                            </script>

                                            @foreach ($detalles as $det)
                                                <tr class="selected" id="fila{{$loop->iteration}}">
                                                  <td><button type="button" class="btn btn-danger btn-simple btn-xs" onclick="eliminar({{$loop->iteration}});"><i class="fa fa-times"></i></button></td>
                                                  <td><input type="hidden"  name="id_articulo[]" value="{{$det->id_articulo}}">{{$det->articulo}}</td>
                                                  <td><input type="hidden"  id="cantidad[]" name="cantidad[]" value="{{$det->cantidad}}">{{$det->cantidad}}</td>
                                                  <td><input type="hidden"  name="precioc[]" value="{{$det->precioc}}">{{$det->precioc}}</td> 
                                                  <td><input type="hidden"  name="etiqueta[]" value="{{$det->etiqueta}}">{{$det->etiqueta}}</td>  
                                                  <input type="hidden"  name="unidad_prod[]" value="{{$det->id_unidad_prod}}">
                                                  <input type="hidden"  name="cantidad_prod[]" value="{{$det->cantidad_prod}}">

                                                  <td>{{$det->precioc*$det->cantidad}}</td> 
                                                  <script type="text/javascript">
                                                    contadorJS = <?php echo $loop->iteration; ?> ;
                                                    cantidadJS = <?php echo $det->cantidad; ?> ;
                                                    preciocJS = <?php echo $det->precioc; ?> ;
                                                    ImpuestoJS = <?php echo $ingreso->impuesto; ?> ;
                                                    

                                                    subtotalJS[contadorJS]=(cantidadJS*preciocJS);
                                                    subtotJS=subtotJS+subtotalJS[contadorJS];
                                                    totalJS=totalJS+subtotalJS[contadorJS];
                                                    taxJS=taxJS+(ImpuestoJS*0.01)*subtotalJS[contadorJS];
                                                    gtJS=subtotJS+taxJS;                                      


                                                    //console.log(contadorJS);
                                                    //console.log(subtotJS);
                                                    //console.log(taxJS);
                                                    //console.log(gtJS);
                                                    
                                                  </script>

                                                </tr>
                                            @endforeach
                                            <tr>
                                               <th></th>
                                               <th></th>
                                               <th></th>
                                               <th></th>
                                               <th>SUB-TOTAL</th>
                                               <th><h4 id="subtot">$ 0.00</h4></th>
                                            </tr>
                                            <tr>
                                               <th></th>
                                               <th></th>
                                               <th></th>
                                               <th></th>
                                               <th>IMPUESTO</th>
                                               <th><h4 id="tax">$ 0.00</h4></th>
                                            </tr>
                                            <tr>
                                               <th></th>
                                               <th></th>
                                               <th></th>
                                               <th></th>
                                               <th>TOTAL</th>
                                               <th><h4 id="gt">$ 0.00</h4></th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                        </tbody>    
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
               
                <div class="row">
                    <div class="col-sm-6" id="guardar">
                        <div class="togglebutton">
	                        <label>
                                @if ($ingreso->estado=='A')
    	                            <input type="checkbox" name="estado" id="estado" value="{{old('estado',$ingreso->estado)}}" onChange="alerta();">
		                                <span style="color: rgba(0,0,0);">¿Finaliza orden? (Ya no se podra editar)</span>
                                @else
                                    <input type="checkbox" name="estado" id="estado" value="{{old('estado',$ingreso->estado)}}" checked disabled>
		                                <span style="color: rgba(0,0,0);">¿Finaliza orden? (Ya no se podra editar)</span>
                                @endif    
	                        </label>
                        </div>

                        <div class="form-group label-floating">  
                            @if ($ingreso->estado=='A')
                                <button class="btn btn-primary" >Actualizar orden de ingreso</button>
                            @else
                                <button class="btn btn-primary" disabled>Orden de ingreso no editable</button>
                            @endif
                            <a href="{{url('/compras/ingreso')}}" class="btn btn-default">Cancelar</a>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

@include('includes.footer')

@push('scripts')


<script>

    $(document).ready(function(){
        $('#bt_add').click(function(){
            agregar();
        });
    });
    

    var cont=0;
    total=0;
    tax=0;
    subtotal=[];
    subtot=0;
    gt=0;

   // $("#guardar").hide();

    $("#pidarticulo").change(mostrarValores);
    $("#pidarticulo").click(mostrarValores);

    $(document).ready(mostrarValores);
    $(document).ready(totales);

    //console.log("cont       = "+cont);
    //console.log("contadorJS = "+contadorJS);


    function totales(){
        if (cont != contadorJS  ){

                for (i=1;i<contadorJS+1;i++){
                    subtotal[i] = subtotalJS[i];
                    //console.log("subtotal -> "+subtotal[i]);    
                }

                //console.log("contadorJS = "+contadorJS);
                
                subtot=subtotJS;
                total=totalJS;
                tax=taxJS;
                gt=gtJS;

                $("#gt").html("$ "+gt.toFixed(4));
                $("#subtot").html("$ "+subtot.toFixed(4));
                $("#tax").html("$ "+tax.toFixed(4));


                //console.log("gtJS = "+gtJS);

        }
    }

    function NumText(string){//solo letras y numeros
    var out = '';
    //Se añaden las letras validas
    var filtro = '_-abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ1234567890';//Caracteres validos
	
    for (var i=0; i<string.length; i++)
       if (filtro.indexOf(string.charAt(i)) != -1) 
	     out += string.charAt(i);
    return out;
    }

    function alerta(){
      if($("#estado").val()=="A"){
        $("#estado").val("F");
        alert('Se finalizara Orden y ya no se podra editar si Actualizas la información de la Orden de Ingreso...');
      }else{
        $("#estado").val("A");
      }    
    }

    function mostrarValores()
    {       
        datosArticulo=document.getElementById('pidarticulo').value.split('_');
        $("#pid_articulo").val(datosArticulo[0]);
        $("#pid_unidad_prod").val(datosArticulo[1]);
        $("#pcantidad_prod").val(datosArticulo[2]);
    }

    function agregar(){
        idarticulo=$("#pid_articulo").val();
        articulo=$("#pidarticulo option:selected").text();
        cantidad=$("#pcantidad").val();
        precioc=$("#pprecioc").val();
        etiqueta=$("#petiqueta").val();
        unidad_prod=$("#pid_unidad_prod").val();
        cantidad_prod=$("#pcantidad_prod").val();
        
        

        if(idarticulo!="" && cantidad!="" && cantidad>0 && precioc!="")
        {
            subtotal[cont]=(cantidad*precioc);
            subtot=subtot+subtotal[cont];
            total=total+subtotal[cont];

            tax=tax+(($("#impuesto").val()*0.001)*subtotal[cont]);
            
            gt=subtot+tax;

            var fila='<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-danger btn-simple btn-xs" onclick="eliminar('+cont+');"><i class="fa fa-times"></i></button></td><td><input type="hidden" name="id_articulo[]" value="'+idarticulo+'">'+articulo+'</td><td><input type="hidden"  name="cantidad[]" value="'+cantidad+'">'+cantidad+'</td><td><input type="hidden"  name="precioc[]" value="'+precioc+'">'+precioc+'</td> <td><input type="hidden"  name="etiqueta[]" value="'+etiqueta+'">'+etiqueta+'</td>  <td>'+subtotal[cont]+'</td> <input type="hidden"  name="unidad_prod[]" value="'+unidad_prod+'"> <input type="hidden" name="cantidad_prod[]" value="'+cantidad_prod+'">';
            
            cont++;
            limpiar();
            $("#gt").html("$ "+gt.toFixed(4));
            $("#subtot").html("$ "+subtot.toFixed(4));
            $("#tax").html("$ "+tax.toFixed(4));
            evaluar();
            $('#detalles').append(fila);
        }
        else
        {
            alert("Error al ingresar la información del producto, favor de revisar.");
        }

    }


    function limpiar(){
        $("#pcantidad").val("");
        $("#pprecioc").val("");
        $("#petiqueta").val("");
        $("#pid_unidad_prod").val("");
        $("#pcantidad_prod").val("");
        $(document).ready(mostrarValores);
    }

    function evaluar(){
        if (total>0)
        {
            $("#guardar").show();
        }
        else
        {
            $("#guardar").hide();   
        }
    } 

    function eliminar(index){

        total=total-subtotal[index];
        
        subtot=subtot-subtotal[index];
        
        tax=tax-(($("#impuesto").val()*0.01)*subtotal[index]);
            
        gt=subtot+tax;
        
        $("#gt").html("$ "+gt.toFixed(4));
        $("#subtot").html("$ "+subtot.toFixed(4));
        $("#tax").html("$ "+tax.toFixed(4));

        $("#fila" + index).remove();
        evaluar();
    }

    function sleep(milliseconds) {
        var start = new Date().getTime();
        for (var i = 0; i < 1e7; i++) {
            if ((new Date().getTime() - start) > milliseconds){
                break;
            }
        }
    }
</script>
@endpush

@endsection

@extends('layouts.app')

@section('title','Jedda')

@section('body-class', 'product-page')

@section('content')

<div class="header header-filter" style="background-image: url('/img/imagen_principal2.png');">
            
</div>

		<div class="main main-raised">
			<div class="container">
		     	<div class="section">
	                <h2 class="title text-center">Registrar nueva orden de salida</h2>
                    
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form method="post" action="{{ url('ventas/venta')}}">
                        {{ csrf_field() }}

                        
                    <div class="row">
                        <div class="col-sm-12">
                                <div class="form-group label-floating">
                                    <label class="control-label">Cliente</label>
                                    <select class="form-control selectpicker" name="idcliente" id="idcliente" data-live-search="true" data-style="btn-primary">
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
                                <input type="text" readonly class="form-control" name="serie_comprobante" value="{{ $nov }}">
                            </div>
                        </div>
                        
                        <div class="col-sm-2">
                            <div class="form-group label-floating">
                                <label class="control-label">Número de comprobante</label>
                                <input type="text" readonly class="form-control" name="num_comprobante" required value="{{ $ncv }}">
                            </div>
                        </div>

                        <div class="col-sm-1">
                            <div class="form-group label-floating">
                                <label class="control-label">Impuesto</label>
                                <input type="number" class="form-control" name="impuesto" id="impuesto" required value="{{ old('impuesto','16')}}">
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group label-floating">
                                <label class="control-label">Invoice QB</label>
                                <input type="text" class="form-control" name="ordenq" id="ordenq" required value="{{ old('ordenq')}}" onkeyup="this.value=NumText(this.value)">
                            </div>
                        </div>


                        <div class="col-sm-3">
                            <div class="form-group label-floating">
                                <label class="control-label">Nota</label>
                                <input type="text" class="form-control" name="notas" id="notas" value="{{ old('notas')}}">
                            </div>
                        </div>

                    </div>
                    
                    <div class="row">
                        <div class="panel panel-primary">
                            <div class="panel-body">
                                <div class="col-sm-2">
                                    <div class="form-group label-floating">
                                    <label class="control-label">Artículo</label>
                                    <select class="form-control selectpicker " name="pidarticulo" id="pidarticulo" data-live-search="true" data-style="btn-primary">
                                        @foreach ($products as $articulo)
                                            <option value="{{$articulo->id}}_{{$articulo->existencia}}_{{$articulo->preciov}}_{{$articulo->etiqueta}}">{{$articulo->articulo}} LOTE: {{$articulo->etiqueta}}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>
                                
                                <div class="col-sm-2">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Cantidad</label>
                                        <input type="number" step="0.01" class="form-control" name="pcantidad" id="pcantidad"  >
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Existencia</label>
                                        <input type="number" step="0.01" disabled class="form-control" name="pexistencia" id="pexistencia"  >
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Precio</label>
                                        <input type="number" step="0.0001" class="form-control" name="ppreciov" id="ppreciov"  >
                                        <input type="hidden" name="petiqueta" id="petiqueta" value="{{ old('petiqueta')}}">
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Descuento</label>
                                        <input type="number" step="0.01" class="form-control" name="pdescuento" id="pdescuento"  >
                                    </div>
                                </div>
                                
     
                                <div class="col-sm-2">
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
                                            <th>Precio de venta</th>
                                            <th>Descuento</th>
                                            <th>Subtotal</th>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th>SUB-TOTAL</th>
                                            <th><h4 id="subtot">$ 0.00</h4><input type="hidden" name="total_venta" id="total_venta"></th>
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

                         <div class="col-sm-6" id="guardar">
                            <div class="form-group label-floating">  
                                <button class="btn btn-primary" >Registro de la orden de venta</button>
                                <a href="{{url('/ventas/venta')}}" class="btn btn-default">Cancelar</a>
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
    $("#guardar").hide();
    $("#pidarticulo").change(mostrarValores);
    $("#pidarticulo").click(mostrarValores);
    $(document).ready(mostrarValores);

    function NumText(string){//solo letras y numeros
    var out = '';
    //Se añaden las letras validas
    var filtro = '_-abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ1234567890';//Caracteres validos
	
    for (var i=0; i<string.length; i++)
       if (filtro.indexOf(string.charAt(i)) != -1) 
	     out += string.charAt(i);
    return out;
    }
    
    function mostrarValores()
    {
        datosArticulo=document.getElementById('pidarticulo').value.split('_');
        $("#pexistencia").val(datosArticulo[1]);
        $("#ppreciov").val(datosArticulo[2]);
        $("#petiqueta").val(datosArticulo[3]);
    }

    function agregar(){
        datosArticulo=document.getElementById('pidarticulo').value.split('_');
        idarticulo=datosArticulo[0];
        et=datosArticulo[3];
        articulo=$("#pidarticulo option:selected").text();
        cantidad=$("#pcantidad").val();
        preciov=$("#ppreciov").val();
        descuento=$("#pdescuento").val();
        existencia=$("#pexistencia").val();

                
        if(idarticulo!="" && cantidad!="" && cantidad>0 && preciov!="")
        {
            if (parseFloat(existencia) >= parseFloat(cantidad))
            {
                subtotal[cont]=(cantidad*preciov-descuento);
                subtot=subtot+subtotal[cont];
                total=total+subtotal[cont];

                tax=tax+(($("#impuesto").val()*0.01)*subtotal[cont]);
                
                gt=subtot+tax;
                /* AQUI AGREGAR ETIQUETA PARA SALIDA (LOTE) Y AGREGAR A REPORTE POR LOTE*/
                var fila='<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-danger btn-simple btn-xs" onclick="eliminar('+cont+');"><i class="fa fa-times"></i></button></td><td><input type="hidden" name="id_articulo[]" value="'+idarticulo+'">'+articulo+'</td><td><input type="hidden" step="0.01" name="cantidad[]" value="'+cantidad+'">'+cantidad+'</td><td><input type="hidden" step="0.01" name="preciov[]" value="'+preciov+'">'+preciov+'</td><td><input type="hidden" step="0.01" name="descuento[]" value="'+descuento+'">'+descuento+' </td> <td>'+subtotal[cont]+'</td> <input type="hidden" name="etiqueta[]" value="'+et+'">';
                
                cont++;
                limpiar();
                $("#gt").html("$ "+gt);
                $("#subtot").html("$ "+subtot);
                $("#total_venta").val(total);
                $("#tax").html("$ "+tax);
                evaluar();
                $('#detalles').append(fila);

            }
            else {
                alert("La cantidad que se quiere vender supera la existencia.");
            }
        }
        else
        {
            alert("Error al ingresar la información del producto, favor de revisar.");
        }

        /*var nueva_existencia=existencia-cantidad;
        datosArticulo[1] = datosArticulo[1].replace(existencia,nueva_existencia);
        $("#pexistencia").val(nueva_existencia);
        $(document).ready(mostrarValores);
        */
    }


    function limpiar(){
        $("#pcantidad").val("");
        $("#ppreciov").val("");
        $("#pdescuento").val("");
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
        
        $("#gt").html("$ "+gt);
        $("#subtot").html("$ "+subtot);
        $("#tax").html("$ "+tax);
        $("#total_venta").val(total);

        $("#fila" + index).remove();
        evaluar();
    }
</script>
@endpush

@endsection

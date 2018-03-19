@extends('layouts.app')

@section('title','Jedda')

@section('body-class', 'product-page')

@section('content')

<div class="header header-filter" style="background-image: url('/img/imagen_principal2.png');">
            
</div>

		<div class="main main-raised">
			<div class="container">
		     	<div class="section">
	                <h2 class="title text-center">Registrar nueva orden de Producción</h2>
                    
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form method="post" action="{{ url('productionorder/production')}}">
                        {{ csrf_field() }}

                    
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group label-floating">
                                <label class="control-label">Orden de Producción</label>
                                <input type="text" class="form-control" name="orden" value="{{ old('orden')}}">
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group label-floating">
                                <label class="control-label">Dirección</label>
                                <input type="text" class="form-control" name="direction" value="{{ old('direction')}}">
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                                <div class="form-group label-floating">
                                    <label class="control-label">Cliente</label>
                                    <select class="form-control selectpicker" name="idcliente" id="idcliente" data-live-search="true" data-style="btn-primary">
                                        @foreach ($clientes as $cliente)
                                            <option value="{{ $cliente->id }}">{{ $cliente->name }}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="id_company" id="id_company" value="{{ auth()->user()->empresa_id}}">
                                </div>
                        </div>
                    </div>
                        
                    <div class="row">

                        <div class="col-sm-3">
                                <div class="form-group label-floating">
                                    <label class="control-label">Materia prima</label>
                                    <select class="form-control selectpicker" name="id_producto_mp" id="id_producto_mp" data-live-search="true" data-style="btn-primary">
                                        @foreach ($materiaprima as $materia)
                                            <option value="{{ $materia->id }}_{{ $materia->etiqueta }}">{{ $materia->articulo }}</option>
                                        @endforeach
                                    </select>                                  
                                    <input type="hidden" name="id_company" id="id_company" value="{{ auth()->user()->empresa_id}}">
                                </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group label-floating">
                                <label class="control-label">Etiqueta(Lote)</label>
                                <input type="text" class="form-control" id="etiqueta_mp" name="etiqueta_mp" value="{{ old('etiqueta_mp')}}">
                            </div>
                        </div>

                        <div class="col-sm-3">
                                <div class="form-group label-floating">
                                    <label class="control-label">Core</label>
                                    <select class="form-control selectpicker" name="id_producto_core" id="id_producto_core" data-live-search="true" data-style="btn-primary">
                                        @foreach ($core as $co)
                                            <option value="{{ $co->id }}_{{ $co->etiqueta }}">{{ $co->articulo }}</option>
                                        @endforeach
                                    </select>
                                </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group label-floating">
                                <label class="control-label">Etiqueta(Lote)</label>
                                <input type="text" class="form-control" id="etiqueta_core" name="etiqueta_core" value="{{ old('etiqueta_core')}}">
                            </div>
                        </div>

                    </div>

                    <div class="row">

                         

                        <div class="col-sm-3">
                                <div class="form-group label-floating">
                                    <label class="control-label">Leader Inicio</label>
                                    <select class="form-control selectpicker" name="id_producto_leader1" id="id_producto_leader1" data-live-search="true" data-style="btn-primary">
                                        @foreach ($leader as $le)
                                            <option value="{{ $le->id }}_{{ $le->etiqueta }}">{{ $le->articulo }}</option>
                                        @endforeach
                                    </select>
                                </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group label-floating">
                                <label class="control-label">Etiqueta(Lote)</label>
                                <input type="text" class="form-control" id="etiqueta_leader1" name="etiqueta_leader1" value="{{ old('etiqueta_leader1')}}">
                            </div>
                        </div>

                        
                        <div class="col-sm-3">
                                <div class="form-group label-floating">
                                    <label class="control-label">Leader Final</label>
                                    <select class="form-control selectpicker" name="id_producto_leader2" id="id_producto_leader2" data-live-search="true" data-style="btn-primary">
                                        @foreach ($leader as $le)
                                            <option value="{{ $le->id }}_{{ $le->etiqueta }}">{{ $le->articulo }}</option>
                                        @endforeach
                                    </select>
                                </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group label-floating">
                                <label class="control-label">Etiqueta(Lote)</label>
                                <input type="text" class="form-control" id="etiqueta_leader2" name="etiqueta_leader2" value="{{ old('etiqueta_leader2')}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                                <div class="form-group label-floating">
                                    <label class="control-label">Etiqueta</label>
                                    <select class="form-control selectpicker" name="id_producto_sticker" id="id_producto_sticker" data-live-search="true" data-style="btn-primary">
                                        @foreach ($sticker as $sti)
                                            <option value="{{ $sti->id }}_{{ $sti->etiqueta }}">{{ $sti->articulo }}</option>
                                        @endforeach
                                    </select>
                                </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group label-floating">
                                <label class="control-label">Etiqueta(Lote)</label>
                                <input type="text" class="form-control" id="etiqueta_sticker" name="etiqueta_sticker" value="{{ old('etiqueta_sticker')}}">
                            </div>
                        </div>
                    </div>
                    </div>

                    <div class="row">
                        <div class="panel panel-primary">
                            <div class="panel-body">
                                
                                <div class="col-sm-1">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Corrida</label>
                                        <input type="text" class="form-control" name="pcorrida" id="pcorrida"  >
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group label-floating">
                                    <label class="control-label">Artículo</label>
                                    <select class="form-control selectpicker " name="pid_producto_pt" id="pid_producto_pt" data-live-search="true" data-style="btn-primary">
                                        @foreach ($productoterminado as $pt)
                                            <option value="{{$pt->id}}_{{$pt->ancho_prod}}_{{$pt->cantidad_prod}}">{{ $pt->name }}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Ancho</label>
                                        <input type="number" step="0.01" class="form-control" name="pancho_prod" id="pancho_prod"  >
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Cantidad</label>
                                        <input type="number" step="0.01" class="form-control" name="pcantidad_pt" id="pcantidad_pt"  >
                                    </div>
                                </div>


                                <div class="col-sm-2">
                                    <div class="form-group label-floating">
                                        <button type="button" id="bt_add" class="btn btn-primary">Agregar</button>
                                    </div>
                                </div>

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

    $("#id_producto_mp").change(mostrarValores);
    $("#id_producto_mp").click(mostrarValores);

    $("#id_producto_core").change(mostrarValores);
    $("#id_producto_core").click(mostrarValores);

    $("#id_producto_leader1").change(mostrarValores);
    $("#id_producto_leader1").click(mostrarValores);

    $("#id_producto_leader2").change(mostrarValores);
    $("#id_producto_leader2").click(mostrarValores);

    $("#id_producto_sticker").change(mostrarValores);
    $("#id_producto_sticker").click(mostrarValores);


    $("#pid_producto_pt").change(mostrarValores);
    $("#pid_producto_pt").click(mostrarValores);

    $(document).ready(mostrarValores);

    function mostrarValores()
    {
        datosMateria=document.getElementById('id_producto_mp').value.split('_');
        $("#etiqueta_mp").val(datosMateria[1]);

        datosCore=document.getElementById('id_producto_core').value.split('_');
        $("#etiqueta_core").val(datosCore[1]);

        datosLeader1=document.getElementById('id_producto_leader1').value.split('_');
        $("#etiqueta_leader1").val(datosLeader1[1]);

        datosLeader2=document.getElementById('id_producto_leader2').value.split('_');
        $("#etiqueta_leader2").val(datosLeader2[1]);

        datosSticker=document.getElementById('id_producto_sticker').value.split('_');
        $("#etiqueta_sticker").val(datosSticker[1]);

        datosProducto=document.getElementById('pid_producto_pt').value.split('_');
        $("#pancho_prod").val(datosProducto[1]);
        
    }

    function agregar(){
        datosArticulo=document.getElementById('pid_producto_pt').value.split('_');
        idarticulo=datosArticulo[0];
        articulo=$("#pidproducto_pt option:selected").text();
        cantidad=$("#pcantidad_pt").val();
        ancho=$("#pancho_pt").val();

                
        if(idarticulo!="" && cantidad!="" && cantidad>0)
        {

                subtotal[cont]=(cantidad*preciov-descuento);
                subtot=subtot+subtotal[cont];
                total=total+subtotal[cont];

                tax=tax+(($("#impuesto").val()*0.01)*subtotal[cont]);
                
                gt=subtot+tax;

                var fila='<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-danger btn-simple btn-xs" onclick="eliminar('+cont+');"><i class="fa fa-times"></i></button></td><td><input type="hidden" name="id_articulo[]" value="'+idarticulo+'">'+articulo+'</td><td><input type="number" step="0.01" name="cantidad[]" value="'+cantidad+'"></td><td><input type="number" step="0.01" name="preciov[]" value="'+preciov+'"></td> </td><td><input type="number" step="0.01" name="descuento[]" value="'+descuento+'"></td> <td>'+subtotal[cont]+'</td> ';
                
                cont++;
                limpiar();
                $("#gt").html("$ "+gt);
                $("#subtot").html("$ "+subtot);
                $("#total_venta").val(total);
                $("#tax").html("$ "+tax);
                evaluar();
                $('#detalles').append(fila);

           
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

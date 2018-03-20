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

                        <div class="col-sm-8">
                                <div class="form-group label-floating">
                                    <label class="control-label">Cliente</label>
                                    <select class="form-control selectpicker" name="idcliente" id="idcliente" data-live-search="true" data-style="btn-default">
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
                                    <select class="form-control selectpicker" name="id_producto_mp" id="id_producto_mp" data-live-search="true" data-style="btn-default">
                                        @foreach ($materiaprima as $materia)
                                            <option value="{{ $materia->id }}_{{ $materia->etiqueta }}_{{ $materia->ancho_prod }}_{{ $materia->cantidad_prod }}_{{ $materia->formula }}_{{ $materia->unidad }}">{{ $materia->articulo }}</option>
                                        @endforeach
                                    </select>                                  
                                    <input type="hidden" name="id_company" id="id_company" value="{{ auth()->user()->empresa_id}}">
                                </div>
                        </div>

                        <div class="col-sm-1">
                            <div class="form-group label-floating">
                                <label class="control-label">Etiqueta(Lote)</label>
                                <input type="text" class="form-control" id="etiqueta_mp" name="etiqueta_mp" value="{{ old('etiqueta_mp')}}">
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group label-floating">
                                <label class="control-label">Ancho</label>
                                <input type="text" disabled class="form-control" id="ancho_mp" name="ancho_mp" value="{{ old('ancho_mp')}}">
                            </div>
                        </div>
                                
                        <div class="col-sm-2">
                            <div class="form-group label-floating">
                                <label class="control-label">Largo</label>
                                <input type="text" disabled class="form-control" id="largo_mp" name="largo_mp" value="{{ old('ancho_mp')}}">
                            </div>
                        </div>
                        
                        <div class="col-sm-2">
                            <div class="form-group label-floating">
                                <label class="control-label"> </label>
                                <input type="text" disabled class="form-control" id="total_mp" name="total_mp" value="{{ old('total_mp')}}">
                            </div>
                        </div>
                        
                        <div class="col-sm-1">
                            <div class="form-group label-floating">
                                <label class="control-label"> </label>
                                <input type="text" disabled class="form-control" id="unidad_mp" name="unidad_mp" value="{{ old('unidad_mp')}}">
                            </div>
                        </div>


                    </div>
                        
                    <div class="row">

                        

                        <div class="col-sm-3">
                                <div class="form-group label-floating">
                                    <label class="control-label">Core</label>
                                    <select class="form-control selectpicker" name="id_producto_core" id="id_producto_core" data-live-search="true" data-style="btn-default">
                                        @foreach ($core as $co)
                                            <option value="{{ $co->id }}_{{ $co->etiqueta }}_{{ $co->ancho_prod }}_{{ $co->cantidad_prod }}_{{ $co->formula }}_{{ $co->unidad }}">{{ $co->articulo }}</option>
                                        @endforeach
                                    </select>
                                </div>
                        </div>

                        <div class="col-sm-1">
                            <div class="form-group label-floating">
                                <label class="control-label">Etiqueta(Lote)</label>
                                <input type="text" class="form-control" id="etiqueta_core" name="etiqueta_core" value="{{ old('etiqueta_core')}}">
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group label-floating">
                                <label class="control-label">Cantidad</label>
                                <input type="text" class="form-control" id="cantidad_core" name="cantidad_core" value="{{ old('cantidad_core')}}">
                            </div>
                        </div>

                        <div class="col-sm-1">
                            <div class="form-group label-floating">
                                <label class="control-label"> </label>
                                <input type="text" disabled class="form-control" id="unidad_core" name="unidad_core" value="{{ old('unidad_core')}}">
                            </div>
                        </div>


                    </div>

                    <div class="row">
                        <div class="col-sm-3">
                                <div class="form-group label-floating">
                                    <label class="control-label">Leader Inicio</label>
                                    <select class="form-control selectpicker" name="id_producto_leader1" id="id_producto_leader1" data-live-search="true" data-style="btn-default">
                                        @foreach ($leader as $le)
                                            <option value="{{ $le->id }}_{{ $le->etiqueta }}_{{ $le->ancho_prod }}_{{ $le->cantidad_prod }}_{{ $le->formula }}_{{ $le->unidad }}"">{{ $le->articulo }}</option>
                                        @endforeach
                                    </select>
                                </div>
                        </div>

                        <div class="col-sm-1">
                            <div class="form-group label-floating">
                                <label class="control-label">Etiqueta(Lote)</label>
                                <input type="text" class="form-control" id="etiqueta_leader1" name="etiqueta_leader1" value="{{ old('etiqueta_leader1')}}">
                            </div>
                        </div>
                        
                        <div class="col-sm-2">
                            <div class="form-group label-floating">
                                <label class="control-label">Ancho</label>
                                <input type="text" disabled class="form-control" id="ancho_leader1" name="ancho_leader1" value="{{ old('ancho_leader1')}}">
                            </div>
                        </div>
                                
                        <div class="col-sm-2">
                            <div class="form-group label-floating">
                                <label class="control-label">Largo</label>
                                <input type="text" disabled class="form-control" id="largo_leader1" name="ancho_leader1" value="{{ old('ancho_leader1')}}">
                            </div>
                        </div>
                        
                        <div class="col-sm-2">
                            <div class="form-group label-floating">
                                <label class="control-label"> </label>
                                <input type="text" disabled class="form-control" id="total_leader1" name="total_leader1" value="{{ old('total_leader1')}}">
                            </div>
                        </div>
                        
                        <div class="col-sm-1">
                            <div class="form-group label-floating">
                                <label class="control-label"> </label>
                                <input type="text" disabled class="form-control" id="unidad_leader1" name="unidad_leader1" value="{{ old('unidad_leader1')}}">
                            </div>
                        </div>
                        </div>

                        <div class="row">
                        <div class="col-sm-3">
                                <div class="form-group label-floating">
                                    <label class="control-label">Leader Final</label>
                                    <select class="form-control selectpicker" name="id_producto_leader2" id="id_producto_leader2" data-live-search="true" data-style="btn-default">
                                        @foreach ($leader as $le)
                                            <option value="{{ $le->id }}_{{ $le->etiqueta }}_{{ $le->ancho_prod }}_{{ $le->cantidad_prod }}_{{ $le->formula }}_{{ $le->unidad }}">{{ $le->articulo }}</option>
                                        @endforeach
                                    </select>
                                </div>
                        </div>

                        <div class="col-sm-1">
                            <div class="form-group label-floating">
                                <label class="control-label">Etiqueta(Lote)</label>
                                <input type="text" class="form-control" id="etiqueta_leader2" name="etiqueta_leader2" value="{{ old('etiqueta_leader2')}}">
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group label-floating">
                                <label class="control-label">Ancho</label>
                                <input type="text" disabled class="form-control" id="ancho_leader2" name="ancho_leader2" value="{{ old('ancho_leader2')}}">
                            </div>
                        </div>
                                
                        <div class="col-sm-2">
                            <div class="form-group label-floating">
                                <label class="control-label">Largo</label>
                                <input type="text" disabled class="form-control" id="largo_leader2" name="largo_leader2" value="{{ old('largo_leader2')}}">
                            </div>
                        </div>
                        
                        <div class="col-sm-2">
                            <div class="form-group label-floating">
                                <label class="control-label"> </label>
                                <input type="text" disabled class="form-control" id="total_leader2" name="total_leader2" value="{{ old('total_leader2')}}">
                            </div>
                        </div>
                        
                        <div class="col-sm-1">
                            <div class="form-group label-floating">
                                <label class="control-label"> </label>
                                <input type="text" disabled class="form-control" id="unidad_leader2" name="unidad_leader2" value="{{ old('unidad_leader2')}}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-3">
                                <div class="form-group label-floating">
                                    <label class="control-label">Etiqueta</label>
                                    <select class="form-control selectpicker" name="id_producto_sticker" id="id_producto_sticker" data-live-search="true" data-style="btn-default">
                                        @foreach ($sticker as $sti)
                                            <option value="{{ $sti->id }}_{{ $sti->etiqueta }}_{{ $sti->ancho_prod }}_{{ $sti->cantidad_prod }}_{{ $sti->formula }}_{{ $sti->unidad }}">{{ $sti->articulo }}</option>
                                        @endforeach
                                    </select>
                                </div>
                        </div>

                        <div class="col-sm-1">
                            <div class="form-group label-floating">
                                <label class="control-label">Etiqueta(Lote)</label>
                                <input type="text" class="form-control" id="etiqueta_sticker" name="etiqueta_sticker" value="{{ old('etiqueta_sticker')}}">
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group label-floating">
                                <label class="control-label">Cantidad</label>
                                <input type="text" class="form-control" id="cantidad_sticker" name="cantidad_sticker" value="{{ old('cantidad_sticker')}}">
                            </div>
                        </div>

                        <div class="col-sm-1">
                            <div class="form-group label-floating">
                                <label class="control-label"> </label>
                                <input type="text" disabled class="form-control" id="unidad_sticker" name="unidad_sticker" value="{{ old('unidad_sticker')}}">
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
                                    <select class="form-control selectpicker " name="pid_producto_pt" id="pid_producto_pt" data-live-search="true" data-style="btn-info">
                                        @foreach ($productoterminado as $pt)
                                            <option value="{{ $pt->id }}_{{ $pt->etiqueta_prod }}_{{ $pt->ancho_prod }}_{{ $pt->cantidad_prod }}_{{ $pt->formula }}_{{ $pt->unidad }}">{{ $pt->name }}</option>
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

                                <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                                <div class="form-group label-floating">
                                    <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                                        <thead style="background-color:#A9D0F5">
                                            <th>Opciones</th>
                                            <th>Artículo</th>
                                            <th>Ancho</th>
                                            <th>Largo</th>
                                            <th>Cantidad</th>
                                            <th>Total</th>
                                        </thead>
                                        <tfoot>

                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th><h4 id="total">0.00</h4></th>
                                            <th><h4 id="subtot">0.00</h4></th>
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
    totart=[];
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
        $("#ancho_mp").val(datosMateria[2]);
        $("#largo_mp").val(datosMateria[3]);
        unidad_mp=datosMateria[5]+'²';
        $("#unidad_mp").val(unidad_mp);        
        tot_mp=$("#ancho_mp").val()*$("#largo_mp").val();
        $("#total_mp").val(tot_mp);



        datosCore=document.getElementById('id_producto_core').value.split('_');
        $("#etiqueta_core").val(datosCore[1]);
        $("#cantidad_core").val(datosCore[3]);
        unidad_core=datosCore[5];
        $("#unidad_core").val(unidad_core);        


        datosLeader1=document.getElementById('id_producto_leader1').value.split('_');
        $("#etiqueta_leader1").val(datosLeader1[1]);
        $("#ancho_leader1").val(datosLeader1[2]);
        $("#largo_leader1").val(datosLeader1[3]);
        unidad_leader1=datosLeader1[5]+'²';
        $("#unidad_leader1").val(unidad_leader1);        
        tot_leader1=$("#ancho_leader1").val()*$("#largo_leader1").val();
        $("#total_leader1").val(tot_leader1);


        datosLeader2=document.getElementById('id_producto_leader2').value.split('_');
        $("#etiqueta_leader2").val(datosLeader2[1]);
        $("#ancho_leader2").val(datosLeader2[2]);
        $("#largo_leader2").val(datosLeader2[3]);
        unidad_leader2=datosLeader2[5]+'²';
        $("#unidad_leader2").val(unidad_leader2);        
        tot_leader2=$("#ancho_leader2").val()*$("#largo_leader2").val();
        $("#total_leader2").val(tot_leader2);

        datosSticker=document.getElementById('id_producto_sticker').value.split('_');
        $("#etiqueta_sticker").val(datosSticker[1]);
        $("#cantidad_sticker").val(datosSticker[3]);
        unidad_sticker=datosSticker[5];
        $("#unidad_sticker").val(unidad_sticker);        


        datosProducto=document.getElementById('pid_producto_pt').value.split('_');
        $("#pancho_prod").val(datosProducto[2]);
        
    }

    function agregar(){
        datosArticulo=document.getElementById('pid_producto_pt').value.split('_');
        idarticulo=datosArticulo[0];
        ancho=datosArticulo[2];
        largo=datosArticulo[3];
        articulo=$("#pid_producto_pt option:selected").text();
        cantidad=$("#pcantidad_pt").val();
        total_ancho=cantidad*ancho;
        //ancho=$("#pancho_pt").val();

                
        if(idarticulo!="" && cantidad!="" && cantidad>0)
        {

                subtotal[cont]=total_ancho;
                subtot=subtot+subtotal[cont];

                totart[cont]=parseFloat(cantidad);
                total=total+totart[cont];

                //total=total+subtotal[cont];
                //total=1;

                //tax=tax+(($("#impuesto").val()*0.01)*subtotal[cont]);
                
                //gt=subtot+tax;

                var fila='<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-danger btn-simple btn-xs" onclick="eliminar('+cont+');"><i class="fa fa-times"></i></button></td><td><input type="hidden" name="id_producto_pt[]" value="'+idarticulo+'">'+articulo+'</td> <td><input type="hidden" name="ancho_producto_pt[]" value="'+ancho+'">'+ancho+'</td> <td><input type="hidden" name="largo_producto_pt[]" value="'+largo+'">'+largo+'</td> <td><input type="hidden" step="0.01" name="cantidad_pt[]" value="'+cantidad+'">'+cantidad+'</td> <td>'+total_ancho+'</td>';
                
                cont++;
                limpiar();
                //$("#gt").html("$ "+gt);
                $("#subtot").html(subtot);
                $("#total").html(total);
                //$("#total_venta").val(total);
                //$("#tax").html("$ "+tax);
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
        $("#pcantidad_pt").val("");
        $("#pancho_pt").val("");
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

@extends('layouts.app')

@section('title','Jedda')

@section('body-class', 'product-page')

@section('content')

<div class="header header-filter" style="background-image: url('/img/imagen_principal2.png');">
            
</div>

<div class="main main-raised">
	<div class="container">
		<div class="section">
            <div class="row">
                <div class="col-sm-2">
                    <img style="width:150px; height:130px;" src="{{ $cim }}" alt="Rounded Raised" class="img-rounded img-responsive img-raised">
                </div>
                <div class="col-sm-10">
	             <h3 class="title text-left">Registrar nueva orden de Producción</h3>
                </div>
            </div>        
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

                    <div class="row" style="background: #FCE7D8;">
                        <div class="col-sm-2">
                            <div class="form-group ">
                                <label class="control-label" style="color: rgba(0,0,0);">Orden de Producción</label>
                                <input type="text" class="form-control" name="orden" value="{{ old('orden')}}">
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group ">
                                <label class="control-label">Fecha</label>
                                <input class="datepicker form-control" type="text" name="fecha_hora" id="fecha_hora" value="{{ old('fecha_hora')}}"/>
                            </div>
                        </div>
                    
                        <div class="col-sm-8">
                            <div class="form-group ">
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
                    <div class="row" style="background: #FCE7D8;">
                        <div class="col-sm-12">
                            <div class="form-group ">
                            </div>
                        </div>
                    </div>    

                    <div class="row" style="background: #D4FAEC;">
                        <div class="col-sm-3">
                            <div class="form-group label-floating">
                                <label class="control-label">Materia prima</label>
                                <select class="form-control selectpicker" name="id_producto_mp" id="id_producto_mp" data-live-search="true" data-style="btn-primary">
                                    @foreach ($materiaprima as $materia)
                                        <option value="{{ $materia->id }}_{{ $materia->etiqueta }}_{{ $materia->ancho_prod }}_{{ $materia->cantidad_prod }}_{{ $materia->formula }}_{{ $materia->unidad }}">{{ $materia->articulo }}</option>
                                    @endforeach
                                </select>                                  
                                <input type="hidden" name="id_company" id="id_company" value="{{ auth()->user()->empresa_id}}">
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group label-floating">
                                <label class="control-label">Etiqueta(Lote)</label>
                                <input type="text" class="form-control" id="etiqueta_mp" name="etiqueta_mp" value="{{ old('etiqueta_mp')}}">
                            </div>
                        </div>

                        <div class="col-sm-1">
                            <div class="form-group label-floating">
                                <label class="control-label">Ancho</label>
                                <input type="text" disabled class="form-control" id="ancho_mp" name="ancho_mp" value="{{ old('ancho_mp')}}">
                            </div>
                        </div>
                                
                        <div class="col-sm-1">
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

                    <div class="row" style="background: #D4FAEC;">
                        <div class="col-sm-2">
                            <div class="form-group ">
                            <label class="control-label">Dirección</label>
                            <select class="form-control selectpicker" name="direction" id="direction" data-live-search="true" data-style="btn-primary">
                                    <option value="In">In</option>
                                    <option value="Out">Out</option>
                                </select>      
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group ">
                                <label class="control-label">Formula</label>
                                <input type="text" disabled class="form-control" id="formula" name="formula" value="{{ old('formula')}}">
                            </div>
                        </div>
                    </div>

                        
                    <div class="row" style="background: #D4FAEC;">
                        <div class="col-sm-3">
                            <div class="form-group label-floating">
                                <label class="control-label">Core</label>
                                <select class="form-control selectpicker" name="id_producto_core" id="id_producto_core" data-live-search="true" data-style="btn-primary">
                                    @foreach ($core as $co)
                                        <option value="{{ $co->id }}_{{ $co->etiqueta }}_{{ $co->ancho_prod }}_{{ $co->cantidad_prod }}_{{ $co->formula }}_{{ $co->unidad }}">{{ $co->articulo }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-3">
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

                    <div class="row" style="background: #D4FAEC;">
                        <div class="col-sm-3">
                            <div class="form-group label-floating">
                                <label class="control-label">Leader Inicio</label>
                                <select class="form-control selectpicker" name="id_producto_leader1" id="id_producto_leader1" data-live-search="true" data-style="btn-primary">
                                    @foreach ($leader as $le)
                                        <option value="{{ $le->id }}_{{ $le->etiqueta }}_{{ $le->ancho_prod }}_{{ $le->cantidad_prod }}_{{ $le->formula }}_{{ $le->unidad }}"">{{ $le->articulo }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group label-floating">
                                <label class="control-label">Etiqueta(Lote)</label>
                                <input type="text" class="form-control" id="etiqueta_leader1" name="etiqueta_leader1" value="{{ old('etiqueta_leader1')}}">
                            </div>
                        </div>
                        
                        <div class="col-sm-1">
                            <div class="form-group label-floating">
                                <label class="control-label">Ancho</label>
                                <input type="text" disabled class="form-control" id="ancho_leader1" name="ancho_leader1" value="{{ old('ancho_leader1')}}">
                            </div>
                        </div>
                                
                        <div class="col-sm-1">
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

                    <div class="row" style="background: #D4FAEC;">
                        <div class="col-sm-3">
                            <div class="form-group label-floating">
                                <label class="control-label">Leader Final</label>
                                <select class="form-control selectpicker" name="id_producto_leader2" id="id_producto_leader2" data-live-search="true" data-style="btn-primary">
                                    @foreach ($leader as $le)
                                        <option value="{{ $le->id }}_{{ $le->etiqueta }}_{{ $le->ancho_prod }}_{{ $le->cantidad_prod }}_{{ $le->formula }}_{{ $le->unidad }}">{{ $le->articulo }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group label-floating">
                                <label class="control-label">Etiqueta(Lote)</label>
                                <input type="text" class="form-control" id="etiqueta_leader2" name="etiqueta_leader2" value="{{ old('etiqueta_leader2')}}">
                            </div>
                        </div>

                        <div class="col-sm-1">
                            <div class="form-group label-floating">
                                <label class="control-label">Ancho</label>
                                <input type="text" disabled class="form-control" id="ancho_leader2" name="ancho_leader2" value="{{ old('ancho_leader2')}}">
                            </div>
                        </div>
                                
                        <div class="col-sm-1">
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

                    <div class="row" style="background: #D4FAEC;">
                        <div class="col-sm-3">
                            <div class="form-group label-floating">
                                <label class="control-label">Leader Envoltura</label>
                                <select class="form-control selectpicker" name="id_producto_leader3" id="id_producto_leader3" data-live-search="true" data-style="btn-primary">
                                    @foreach ($leader as $le)
                                        <option value="{{ $le->id }}_{{ $le->etiqueta }}_{{ $le->ancho_prod }}_{{ $le->cantidad_prod }}_{{ $le->formula }}_{{ $le->unidad }}"">{{ $le->articulo }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group label-floating">
                                <label class="control-label">Etiqueta(Lote)</label>
                                <input type="text" class="form-control" id="etiqueta_leader3" name="etiqueta_leader3" value="{{ old('etiqueta_leader3')}}">
                            </div>
                        </div>
                        
                        <div class="col-sm-1">
                            <div class="form-group label-floating">
                                <label class="control-label">Ancho</label>
                                <input type="text" disabled class="form-control" id="ancho_leader3" name="ancho_leader3" value="{{ old('ancho_leader3')}}">
                            </div>
                        </div>
                                
                        <div class="col-sm-1">
                            <div class="form-group label-floating">
                                <label class="control-label">Largo</label>
                                <input type="text" disabled class="form-control" id="largo_leader3" name="ancho_leader3" value="{{ old('ancho_leader3')}}">
                            </div>
                        </div>
                        
                        <div class="col-sm-2">
                            <div class="form-group label-floating">
                                <label class="control-label"> </label>
                                <input type="text" disabled class="form-control" id="total_leader3" name="total_leader3" value="{{ old('total_leader3')}}">
                            </div>
                        </div>
                        
                        <div class="col-sm-1">
                            <div class="form-group label-floating">
                                <label class="control-label"> </label>
                                <input type="text" disabled class="form-control" id="unidad_leader3" name="unidad_leader3" value="{{ old('unidad_leader3')}}">
                            </div>
                        </div>
                    </div>


                    <div class="row" style="background: #D4FAEC;">
                        <div class="col-sm-3">
                            <div class="form-group label-floating">
                                <label class="control-label">Etiqueta</label>
                                <select class="form-control selectpicker" name="id_producto_sticker" id="id_producto_sticker" data-live-search="true" data-style="btn-primary">
                                    @foreach ($sticker as $sti)
                                        <option value="{{ $sti->id }}_{{ $sti->etiqueta }}_{{ $sti->ancho_prod }}_{{ $sti->cantidad_prod }}_{{ $sti->formula }}_{{ $sti->unidad }}">{{ $sti->articulo }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-3">
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

                    <div class="row" style="background: #D4FAEC;">
                        <div class="col-sm-12">
                            <div class="form-group ">
                            </div>
                        </div>
                    </div>    

                </div>

                <div class="row">
                    <div class="panel panel-primary">
                        <div class="panel-body">
                                
                            <div class="col-sm-2">
                                <div class="form-group ">
                                    <label class="control-label">Desperdicio lado derecho</label>
                                    <input type="number" step="0.001" class="form-control" name="desp_der" id="desp_der"  >
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <div class="form-group ">
                                    <label class="control-label">Desperdicio lado izquierdo</label>
                                    <input type="number" step="0.001" class="form-control" name="desp_izq" id="desp_izq"  >
                                </div>
                            </div>
                            
                            <div class="col-sm-2">
                            <div class="form-group ">
                                <label class="control-label">Desperdicio por corrida </label>
                                <input type="number" step="0.001" disabled class="form-control" id="total_desp" name="total_desp" value="{{ old('total_desp')}}">
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group ">
                                <label class="control-label">Rollos por corrida </label>
                                <input type="number" step="0.001" disabled class="form-control" id="rollos_materia_prima" name="rollos_materia_prima" value="{{ old('rollos_materia_prima')}}">
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group ">
                                <label class="control-label">Corridas necesarias </label>
                                <input type="number" step="0.001" disabled class="form-control" id="corridas_materia_prima" name="corridas_materia_prima" value="{{ old('corridas_materia_prima')}}">
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group ">
                                <label class="control-label">Rollos Totales </label>
                                <input type="number" step="0.001" disabled class="form-control" id="rollos_totales" name="rollos_totales" value="{{ old('rollos_totales')}}">
                            </div>
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
                                            <th>Corrida</th>
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
                                            <th></th>
                                            <th><h4 id="total">0.00</h4></th>
                                            <th><div id="t1"><h4 id="subtot">0.00</h4></div></th>
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

                <div class="col-sm-6" id="guardar">
                    <div class="form-group label-floating">  
                        <button class="btn btn-primary" >Registro de la orden de producción</button>
                        <a href="{{url('/productionorder/production')}}" class="btn btn-default">Cancelar</a>
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

    $("#id_producto_leader3").change(mostrarValores);
    $("#id_producto_leader3").click(mostrarValores);

    $("#id_producto_sticker").change(mostrarValores);
    $("#id_producto_sticker").click(mostrarValores);

    $("#pid_producto_pt").change(mostrarValores);
    $("#pid_producto_pt").click(mostrarValores);

    $("#desp_der").change(mostrarValores);
    $("#desp_der").click(mostrarValores);
    $("#desp_izq").change(mostrarValores);
    $("#desp_izq").click(mostrarValores);


    $(document).ready(mostrarValores);

    function mostrarValores()
    {       
        desp_der=$("#desp_der").val();
        desp_izq=$("#desp_izq").val();
        total_desp=parseFloat(desp_der)+parseFloat(desp_izq);
        $("#total_desp").val(total_desp);


        datosMateria=document.getElementById('id_producto_mp').value.split('_');
        $("#etiqueta_mp").val(datosMateria[1]);
        $("#ancho_mp").val(datosMateria[2]);
        $("#largo_mp").val(datosMateria[3]);
        $("#formula").val(datosMateria[4]);
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

        datosLeader3=document.getElementById('id_producto_leader3').value.split('_');
        $("#etiqueta_leader3").val(datosLeader3[1]);
        $("#ancho_leader3").val(datosLeader3[2]);
        $("#largo_leader3").val(datosLeader3[3]);
        unidad_leader3=datosLeader3[5]+'²';
        $("#unidad_leader3").val(unidad_leader3);        
        tot_leader3=$("#ancho_leader3").val()*$("#largo_leader3").val();
        $("#total_leader3").val(tot_leader3);

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
        corrida=$("#pcorrida").val();
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

                // calculos para obtener corridas...
                //Math.trunc(13.37);    13
                //var resultado = operador1 / operador2; 
                //var resto = operador1 % operador2; 

                amp=$("#ancho_mp").val();
                at=parseFloat(amp)-parseFloat(total_desp);
                rollos_materia_prima=Math.trunc(at/parseFloat(ancho));
                $("#rollos_materia_prima").val(rollos_materia_prima);

                ver_residuo=parseFloat(cantidad) % parseFloat(rollos_materia_prima);

                var corridas_materia_prima=0;
                if(ver_residuo>0){
                 corridas_materia_prima=Math.trunc(parseFloat(cantidad)/parseFloat(rollos_materia_prima))+1;
                }
                else
                {
                  corridas_materia_prima=Math.trunc(parseFloat(cantidad)/parseFloat(rollos_materia_prima));   
                }
                $("#corridas_materia_prima").val(corridas_materia_prima);
                
                rollos_totales=parseFloat(corridas_materia_prima)*parseFloat(rollos_materia_prima);
                $("#rollos_totales").val(rollos_totales);


                


                var fila='<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-danger btn-simple btn-xs" onclick="eliminar('+cont+');"><i class="fa fa-times"></i></button></td> <td><input type="hidden" name="id_corrida_pt[]" value="'+corrida+'">'+corrida+'</td> <td><input type="hidden" name="id_producto_pt[]" value="'+idarticulo+'">'+articulo+'</td> <td><input type="hidden" name="ancho_producto_pt[]" value="'+ancho+'">'+ancho+'</td> <td><input type="hidden" name="largo_producto_pt[]" value="'+largo+'">'+largo+'</td> <td><input type="hidden" step="0.01" name="cantidad_pt[]" value="'+cantidad+'">'+cantidad+'</td> <td>'+total_ancho+'</td>';
                
                cont++;
                limpiar();
                
                //alert(v1+" "+subtot);
                

                $("#subtot").html(subtot);
                $("#total").html(total);
                evaluar();
                $('#detalles').append(fila);

                if(parseFloat(subtot) > parseFloat($("#ancho_mp").val()))
                {
                    document.getElementById('t1').style.color = '#AC0202';
                    document.getElementById("t1").style.fontWeight="bold";
                }
                else
                    document.getElementById('t1').style.color = '#000000';   

           
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

        //subtotal[index]=total_ancho;

        //alert(subtot+','+subtotal[index]);
        subtot=parseFloat(subtot.toFixed(2))-parseFloat(subtotal[index].toFixed(2));


        //totart[index]=parseFloat(cantidad);
        total=total-parseFloat(totart[index]);


        //subtot.toFixed(2);
        //total.toFixed(2);
        
        $("#subtot").html(subtot.toFixed(2));
        $("#total").html(total.toFixed(2));

        if(parseFloat(subtot) > parseFloat($("#ancho_mp").val()))
        {
            document.getElementById('t1').style.color = '#AC0202';
            document.getElementById("t1").style.fontWeight="bold";
        }
        else
           document.getElementById('t1').style.color = '#000000';   


        $("#fila" + index).remove();
        evaluar();
    }


</script>
@endpush


<script>
    $('.datepicker').datepicker({
    weekStart:1
    });
</script>


@endsection

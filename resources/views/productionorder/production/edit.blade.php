@extends('layouts.app')

@section('title','Jedda')

@section('body-class', 'product-page')

@section('styles')
<style>
.datagrid table { 
    border-collapse: collapse; 
    text-align: left; 
    width: 100%; } 
.datagrid {
    font: normal 12px/150% Arial, Helvetica, sans-serif; 
    background: #fff; 
    overflow: hidden; 
    border: 1px solid #652299; 
    -webkit-border-radius: 3px; 
    -moz-border-radius: 3px; 
    border-radius: 3px; }
.datagrid table td, .datagrid table th { 
    padding: 3px 10px; }
.datagrid table thead th {
    background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #652299), color-stop(1, #4D1A75) );
    background:-moz-linear-gradient( center top, #652299 5%, #4D1A75 100% );
    filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#652299', endColorstr='#4D1A75');
    background-color:#652299; 
    color:#FFFFFF; 
    font-size: 15px; 
    font-weight: bold; 
    border-left: 1px solid #714399; } 
.datagrid table thead th:first-child { 
    border: none; }
.datagrid table tbody td { 
    color: #4D1A75; 
    border-left: 1px solid #E7BDFF;
    font-size: 12px;
    font-weight: normal;
    text-align: right; }
.datagrid table tbody .alt td { 
    background: #F4E3FF; 
    color: #4D1A75; }
.datagrid table tbody td:first-child { 
    border-left: none; }
.datagrid table tbody tr:last-child td { 
    border-bottom: none; }

.datagrid table tfoot td div { 
    border-top: 1px solid #652299;
    background: #F4E3FF;} 
.datagrid table tfoot td h6{
    font-size: 12px;
    font-weight: bold; 
    text-align: right;
}
.datagrid table tfoot td { 
    padding: 0; 
    font-size: 12px } 
.datagrid table tfoot td div{ 
    padding: 2px; }
.datagrid table tfoot td ul { 
    margin: 0; 
    padding:0; 
    list-style: none; 
    text-align: right; }
.datagrid table tfoot td {
    border-left: 1px solid #E7BDFF;
}
.datagrid table tfoot  li { 
    display: inline; }
.datagrid table tfoot li a { 
    text-decoration: none; 
    display: inline-block;  
    padding: 2px 8px; 
    margin: 1px;
    color: #FFFFFF;
    border: 1px solid #652299;
    -webkit-border-radius: 3px; 
    -moz-border-radius: 3px; 
    border-radius: 3px; 
    background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #652299), color-stop(1, #4D1A75) );
    background:-moz-linear-gradient( center top, #652299 5%, #4D1A75 100% );
    filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#652299', endColorstr='#4D1A75');
    background-color:#652299; }
.datagrid table tfoot ul.active, .datagrid table tfoot ul a:hover { 
    text-decoration: none;
    border-color: #4D1A75; 
    color: #FFFFFF; 
    background: none; 
    background-color:#652299;}
div.dhtmlx_window_active, div.dhx_modal_cover_dv { position: fixed !important; }
</style>
@endsection


@section('content')

<div class="header header-filter" style="background-image: url('/img/imagen_principal2.png');">
            
</div>



<div class="main main-raised">
    <div class="container">
        <div class="section">
            <div class="row">
                <div class="col-sm-10">
                    <h3 class="title text-left">Editar nueva orden de Producción</h3>
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
            
            <br>        
            
            <form method="post" action="{{ url('productionorder/production')}}">
            {{ csrf_field() }}
                
                <ul class="nav nav-pills nav-pills-primary">
                    <li class="nav-item active"><a class="nav-link active" href="#pill1" data-toggle="tab">Información Principal</a></li>
                    <li class="nav-item"><a class="nav-link" href="#pill2" data-toggle="tab">Materia prima</a></li>
                    <li class="nav-item"><a class="nav-link" href="#pill3" data-toggle="tab">Calculos y productos</a></li>
                    <li class="nav-item"><a class="nav-link" href="#pill4" data-toggle="tab">Resumen</a></li>
                </ul>


                <div class="tab-content tab-space">
                    <div class="tab-pane active" id="pill1">
                        <div class="panel panel-primary">
                            <div class="panel-body">
                                <div class="row" >
                                    <div class="col-sm-2">
                                        <div class="form-group ">
                                            <label class="control-label" style="color: rgba(0,0,0);">Orden de Producción</label>
                                            <input type="text" class="form-control" readonly id="orden" name="orden" value="{{ old('orden',$op->orden)}}">
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="form-group ">
                                            <label class="control-label" style="color: rgba(0,0,0);">Fecha</label>
                                            <input class="datepicker form-control" type="text" name="fecha_hora" id="fecha_hora" value="{{ old('fecha_hora',$op->fecha_hora)}}"/>
                                        </div>
                                    </div>
                        
                                    <div class="col-sm-6">
                                        <div class="form-group ">
                                            <label class="control-label" style="color: rgba(0,0,0);">Cliente</label>
                                            <select class="form-control selectpicker" name="idcliente" id="idcliente" data-live-search="true" data-style="btn-primary">
                                                @foreach ($clientes as $cliente)
                                                    <option value="{{ $cliente->id }}" @if($cliente->id == old('cliente->id',$op->idcliente)) selected @endif >{{ $cliente->name }}</option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" name="id_company" id="id_company" value="{{ auth()->user()->empresa_id}}">
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="form-group ">
                                            <label class="control-label" style="color: rgba(0,0,0);">Orden de compra cliente</label>
                                            <input type="text" class="form-control" name="orden_cliente" value="{{ old('orden_cliente',$op->orden_cliente)}}" onkeyup="this.value=NumText(this.value)">
                                        </div>
                                    </div>
                                </div>    

                                <div class="row" >
                                    <div class="col-sm-12">
                                        <div class="form-group ">
                                        </div>
                                    </div>
                                </div>   
                            </div>
                        </div>
                    </div>
                

                    <div class="tab-pane" id="pill2">
                        <div class="panel panel-primary">
                            <div class="panel-body">

                                <div class="row" >
                                    <div class="col-sm-3">
                                        <div class="form-group label-floating">
                                            <label class="control-label" style="color: rgba(0,0,0);">Materia prima</label>
                                            <select class="form-control " name="id_producto_mp" id="id_producto_mp" data-live-search="true" data-style="btn-default">
                                                @foreach ($materiaprima as $materia)
                                                    <option value="{{ $materia->id }}_{{ $materia->etiqueta }}_{{ $materia->ancho_prod }}_{{ $materia->cantidad_prod }}_{{ $materia->formula }}_{{ $materia->unidad }}_{{ $materia->articulo }}_{{ $materia->id_unidad }}_{{ $materia->precioc }}_{{ $materia->preciov }}_{{$materia->id_product}}_{{$materia->largo}}" @if($materia->id_product == $op->id_producto_mp and $materia->etiqueta == $op->etiqueta_mp) selected @endif>{{ $materia->articulo }}</option>
                                                @endforeach
                                            </select>                                  
                                            <input type="hidden" name="id_company" id="id_company" value="{{ auth()->user()->empresa_id}}">

                                            <input type="hidden" name="tempo_id_producto_mp" id="tempo_id_producto_mp" value="{{ old('tempo_id_producto_mp')}}">

                                            <input type="hidden" name="tempo_id_unidad_mp" id="tempo_id_unidad_mp" value="{{ old('tempo_id_unidad_mp')}}">

                                            <input type="hidden" name="tempo_precioc_mp" id="tempo_precioc_mp" value="{{ old('tempo_precioc_mp')}}">

                                            <input type="hidden" name="tempo_preciov_mp" id="tempo_preciov_mp" value="{{ old('tempo_preciov_mp')}}">
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group label-floating">
                                            <label class="control-label" style="color: rgba(0,0,0);">Etiqueta(Lote)</label>
                                            <input type="text" readonly class="form-control" id="etiqueta_mp" name="etiqueta_mp" value="{{ old('etiqueta_mp',$op->etiqueta_mp)}}">
                                        </div>
                                    </div>

                                    <div class="col-sm-1">
                                        <div class="form-group label-floating">
                                            <label class="control-label" style="color: rgba(0,0,0);">Ancho</label>
                                            <input type="text" readonly class="form-control" id="ancho_mp" name="ancho_mp" value="{{ old('ancho_mp')}}">
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-1">
                                        <div class="form-group label-floating">
                                            <label class="control-label" style="color: rgba(0,0,0);">Largo</label>
                                            <input type="number" step="0.001" readonly class="form-control" id="largo_mp" name="largo_mp" value="{{ old('largo_mp')}}">
                                        </div>
                                    </div>
                            
                                    <div class="col-sm-2">
                                        <div class="form-group label-floating">
                                            <label class="control-label"> </label>
                                            <input type="text" readonly class="form-control" id="total_mp" name="total_mp" value="{{ old('total_mp')}}">
                                        </div>
                                    </div>
                            
                                    <div class="col-sm-1">
                                        <div class="form-group label-floating">
                                            <label class="control-label"> </label>
                                            <input type="text" readonly class="form-control" id="unidad_mp" name="unidad_mp" value="{{ old('unidad_mp')}}">
                                        </div>
                                    </div>

                                </div>

                                <div class="row" >
                                    <div class="col-sm-2">
                                        <div class="form-group label-floating">
                                            <label class="control-label" style="color: rgba(0,0,0);">Dirección</label>
                                            <select class="form-control " name="direction" id="direction" data-live-search="true" data-style="btn-primary">
                                                <option value="In" @if($op->direction == "In") selected @endif>In</option>
                                                <option value="Out" @if($op->direction == "Out") selected @endif>Out</option>
                                            </select>      
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="form-group label-floating">
                                            <label class="control-label" style="color: rgba(0,0,0);">Formula</label>
                                            <input type="text" readonly class="form-control" id="formula" name="formula" value="{{ old('formula')}}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row" >
                                    <div class="col-sm-3">
                                        <div class="form-group label-floating">
                                            <label class="control-label " style="color: rgba(0,0,0);">Core</label>
                                            <select class="form-control " name="id_producto_core" id="id_producto_core" data-live-search="true" data-style="btn-primary">
                                                @foreach ($core as $co)
                                                    <option value="{{ $co->id }}_{{ $co->etiqueta }}_{{ $co->ancho_prod }}_{{ $co->cantidad_prod }}_{{ $co->formula }}_{{ $co->unidad }}_{{ $co->articulo }}_{{ $co->id_unidad }}_{{ $co->precioc }}_{{ $co->preciov }}" @if($co->id == $op->id_producto_core and $co->etiqueta == $op->etiqueta_core) selected @endif>{{ $co->articulo }}</option>
                                                @endforeach
                                            </select>

                                            <input type="hidden" name="tempo_id_producto_core" id="tempo_id_producto_core" value="{{ old('tempo_id_producto_core')}}">

                                            <input type="hidden" name="tempo_id_unidad_core" id="tempo_id_unidad_core" value="{{ old('tempo_id_unidad_core')}}">

                                            <input type="hidden" name="tempo_precioc_core" id="tempo_precioc_core" value="{{ old('tempo_precioc_core')}}">

                                            <input type="hidden" name="tempo_preciov_core" id="tempo_preciov_core" value="{{ old('tempo_preciov_core')}}">

                                        </div>
                                    </div>


                                    <div class="col-sm-3">
                                        <div class="form-group label-floating">
                                            <label class="control-label" style="color: rgba(0,0,0);">Etiqueta(Lote)</label>
                                            <input type="text" class="form-control" id="etiqueta_core" name="etiqueta_core" value="{{ old('etiqueta_core')}}">
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="form-group label-floating">
                                            <label class="control-label" style="color: rgba(0,0,0);">Cantidad</label>
                                            <input type="text" readonly class="form-control" id="cantidad_core" name="cantidad_core" value="{{ old('cantidad_core')}}">
                                        </div>
                                    </div>

                                    <div class="col-sm-1">
                                        <div class="form-group label-floating">
                                            <label class="control-label"> </label>
                                            <input type="text" readonly class="form-control" id="unidad_core" name="unidad_core" value="{{ old('unidad_core')}}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row" >
                                    <div class="col-sm-3">
                                        <div class="form-group ">
                                            <label class="control-label" style="color: rgba(0,0,0);">Leader Inicio</label>
                                            <select class="form-control " name="id_producto_leader1" id="id_producto_leader1" data-live-search="true" data-style="btn-primary">
                                                @foreach ($leader as $le)
                                                    <option value="{{ $le->id }}_{{ $le->etiqueta }}_{{ $le->ancho_prod }}_{{ $le->cantidad_prod }}_{{ $le->formula }}_{{ $le->unidad }}_{{ $le->articulo }}_{{ $le->id_unidad }}_{{ $le->precioc }}_{{ $le->preciov }}_{{ $le->id_product }}" @if($le->id_product == $op->id_producto_leader1 and $le->etiqueta == $op->etiqueta_leader1) selected @endif>{{ $le->articulo }}</option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" name="tempo_id_producto_leader1" id="tempo_id_producto_leader1" value="{{ old('tempo_id_producto_leader1')}}">
                                            <input type="hidden" name="tempo_id_unidad_leader1" id="tempo_id_unidad_leader1" value="{{ old('tempo_id_unidad_leader1')}}">

                                            <input type="hidden" name="tempo_precioc_leader1" id="tempo_precioc_leader1" value="{{ old('tempo_precioc_leader1')}}">

                                            <input type="hidden" name="tempo_preciov_leader1" id="tempo_preciov_leader1" value="{{ old('tempo_preciov_leader1')}}">

                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group ">
                                            <label class="control-label" style="color: rgba(0,0,0);">Etiqueta(Lote)</label>
                                            <input type="text" class="form-control" id="etiqueta_leader1" name="etiqueta_leader1" value="{{ old('etiqueta_leader1')}}">
                                        </div>
                                    </div>
                                
                                    <div class="col-sm-1">
                                        <div class="form-group ">
                                            <label class="control-label" style="color: rgba(0,0,0);">Ancho</label>
                                            <input type="text" readonly class="form-control" id="ancho_leader1" name="ancho_leader1" value="{{ old('ancho_leader1')}}">
                                        </div>
                                    </div>
                                        
                                    <div class="col-sm-1">
                                        <div class="form-group ">
                                            <label class="control-label" style="color: rgba(0,0,0);">Largo</label>
                                            <input type="text" readonly class="form-control" id="largo_leader1" name="largo_leader1" value="{{ old('largo_leader1')}}">
                                        </div>
                                    </div>
                        
                                    <div class="col-sm-2">
                                        <div class="form-group ">
                                            <label class="control-label"> </label>
                                            <input type="text" readonly class="form-control" id="total_leader1" name="total_leader1" value="{{ old('total_leader1')}}">
                                        </div>
                                    </div>
                                
                                    <div class="col-sm-1">
                                        <div class="form-group ">
                                            <label class="control-label"> </label>
                                            <input type="text" readonly class="form-control" id="unidad_leader1" name="unidad_leader1" value="{{ old('unidad_leader1')}}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row" >
                                    <div class="col-sm-3">
                                        <div class="form-group ">
                                            <label class="control-label" style="color: rgba(0,0,0);">Leader Final</label>
                                            <select class="form-control " name="id_producto_leader2" id="id_producto_leader2" data-live-search="true" data-style="btn-primary">

                                            </select>
                                            <input type="hidden" name="tempo_id_producto_leader2" id="tempo_id_producto_leader2" value="{{ old('tempo_id_producto_leader2')}}">
                                            <input type="hidden" name="tempo_id_unidad_leader2" id="tempo_id_unidad_leader2" value="{{ old('tempo_id_unidad_leader2')}}">

                                            <input type="hidden" name="tempo_precioc_leader2" id="tempo_precioc_leader2" value="{{ old('tempo_precioc_leader2')}}">

                                            <input type="hidden" name="tempo_preciov_leader2" id="tempo_preciov_leader2" value="{{ old('tempo_preciov_leader2')}}">
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group ">
                                            <label class="control-label" style="color: rgba(0,0,0);">Etiqueta(Lote)</label>
                                            <input type="text" class="form-control" id="etiqueta_leader2" name="etiqueta_leader2" value="{{ old('etiqueta_leader2')}}">
                                        </div>
                                    </div>

                                    <div class="col-sm-1">
                                        <div class="form-group ">
                                            <label class="control-label" style="color: rgba(0,0,0);">Ancho</label>
                                            <input type="text" readonly class="form-control" id="ancho_leader2" name="ancho_leader2" value="{{ old('ancho_leader2')}}">
                                        </div>
                                    </div>
                                
                                    <div class="col-sm-1">
                                        <div class="form-group ">
                                            <label class="control-label" style="color: rgba(0,0,0);">Largo</label>
                                            <input type="text" readonly class="form-control" id="largo_leader2" name="largo_leader2" value="{{ old('largo_leader2')}}">
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-2">
                                        <div class="form-group ">
                                            <label class="control-label">.</label>
                                            <input type="text" readonly class="form-control" id="total_leader2" name="total_leader2" value="{{ old('total_leader2')}}">
                                        </div>
                                    </div>
                        
                                    <div class="col-sm-1">
                                        <div class="form-group ">
                                            <label class="control-label">.</label>
                                            <input type="text" readonly class="form-control" id="unidad_leader2" name="unidad_leader2" value="{{ old('unidad_leader2')}}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row" >
                                    <div class="col-sm-3">
                                        <div class="form-group ">
                                            <label class="control-label"  style="color: rgba(0,0,0);">Leader Envoltura</label>
                                            <select class="form-control " name="id_producto_leader3" id="id_producto_leader3" data-live-search="true" data-style="btn-primary">
                                                
                                            </select>
                                            <input type="hidden" name="tempo_id_producto_leader3" id="tempo_id_producto_leader3" value="{{ old('tempo_id_producto_leader3')}}">

                                            <input type="hidden" name="tempo_id_unidad_leader3" id="tempo_id_unidad_leader3" value="{{ old('tempo_id_unidad_leader3')}}">

                                            <input type="hidden" name="tempo_precioc_leader3" id="tempo_precioc_leader3" value="{{ old('tempo_precioc_leader3')}}">

                                            <input type="hidden" name="tempo_preciov_leader3" id="tempo_preciov_leader3" value="{{ old('tempo_preciov_leader3')}}">
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group ">
                                            <label class="control-label"  style="color: rgba(0,0,0);">Etiqueta(Lote)</label>
                                            <input type="text" class="form-control" id="etiqueta_leader3" name="etiqueta_leader3" value="{{ old('etiqueta_leader3')}}">
                                        </div>
                                    </div>
                        
                                    <div class="col-sm-1">
                                        <div class="form-group ">
                                            <label class="control-label" style="color: rgba(0,0,0);">Ancho</label>
                                            <input type="text" readonly class="form-control" id="ancho_leader3" name="ancho_leader3" value="{{ old('ancho_leader3')}}">
                                        </div>
                                    </div>
                                            
                                    <div class="col-sm-1">
                                        <div class="form-group ">
                                            <label class="control-label" style="color: rgba(0,0,0);">Largo</label>
                                            <input type="text" readonly class="form-control" id="largo_leader3" name="largo_leader3" value="{{ old('largo_leader3')}}">
                                        </div>
                                    </div>
                            
                                    <div class="col-sm-2">
                                        <div class="form-group ">
                                            <label class="control-label"> </label>
                                            <input type="text" readonly class="form-control" id="total_leader3" name="total_leader3" value="{{ old('total_leader3')}}">
                                        </div>
                                    </div>
                            
                                    <div class="col-sm-1">
                                        <div class="form-group ">
                                            <label class="control-label"> </label>
                                            <input type="text" readonly class="form-control" id="unidad_leader3" name="unidad_leader3" value="{{ old('unidad_leader3')}}">
                                        </div>
                                    </div>
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

<script src="/js/filtros/filtros.js"></script>






<script>




    $(document).ready(function(){
        $('#bt_add').click(function(){
            agregar();
        });
    });

    $(document).ready(function(){
        $('#bt_add2').click(function(){
            agregar2();
        });
    });

    $(document).ready(function(){
        mostrarValores();
        
    });

    
        




    var cont=0;
    var cont2=0;
    var caracteresfila=0;
    total=0;
    tax=0;
    subtotal=[];
    totart=[];
    subtot=0;
    gt=0;

    /* Seccion para llevar control de:
        - Cantidad de Rollos capturados de producto terminado
        - Ancho
        - Largo
    */

    mprollos=[];
    anchorollo=[];
    largorollo=[];
    despcorrida=[];
    rolloscorrida=[];



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

    $("#desp_der").change(evaluar_desp);
    $("#desp_der").click(evaluar_desp);
    $(document).ready(desp_der);

    $("#desp_izq").change(evaluar_desp);
    $("#desp_izq").click(evaluar_desp);
    $(document).ready(desp_izq);

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
        desp_der=$("#desp_der").val();
        desp_izq=$("#desp_izq").val();
        total_desp=parseFloat(desp_der)+parseFloat(desp_izq);
        $("#total_desp").val(total_desp);

        datosMateria=document.getElementById('id_producto_mp').value.split('_');

        $("#tempo_id_producto_mp").val(datosMateria[10]);
                
        $("#etiqueta_mp").val(datosMateria[1]);
        $("#ancho_mp").val(datosMateria[2]);
        $("#largo_mp").val(datosMateria[11]);
        $("#largo_mp_original").val(datosMateria[3]);
        $("#formula").val(datosMateria[4]);
        unidad_mp=datosMateria[5]+'²';
        $("#unidad_mp").val(unidad_mp);        
        tot_mp=$("#ancho_mp").val()*$("#largo_mp").val();
        $("#total_mp").val(tot_mp);
        $("#materia_prima").val(datosMateria[6]);
        $("#tempo_id_unidad_mp").val(datosMateria[7]);
        $("#tempo_precioc_mp").val(datosMateria[8]);
        $("#tempo_preciov_mp").val(datosMateria[9]);



        datosCore=document.getElementById('id_producto_core').value.split('_');

        $("#tempo_id_producto_core").val(datosCore[0]);

        $("#etiqueta_core").val(datosCore[1]);
        $("#cantidad_core").val(datosCore[3]);
        $("#cantidad_core_original").val(datosCore[3]);
        unidad_core=datosCore[5];
        tot_mp=$("#ancho_mp").val()*$("#largo_mp").val();
        $("#unidad_core").val(unidad_core);    
        $("#core").val(datosCore[6]);
        $("#tempo_id_unidad_core").val(datosCore[7]);
        $("#tempo_precioc_core").val(datosCore[8]);
        $("#tempo_preciov_core").val(datosCore[9]);    


        datosLeader1=document.getElementById('id_producto_leader1').value.split('_');

        $("#tempo_id_producto_leader1").val(datosLeader1[10]);

        $("#etiqueta_leader1").val(datosLeader1[1]);
        $("#ancho_leader1").val(datosLeader1[2]);
        $("#largo_leader1").val(datosLeader1[3]);
        $("#largo_leader1_original").val(datosLeader1[3]);
        unidad_leader1=datosLeader1[5]+'²';
        $("#unidad_leader1").val(unidad_leader1);    
        $("#leader1").val(datosLeader1[6]);    
        tot_leader1=$("#ancho_leader1").val()*$("#largo_leader1").val();
        $("#total_leader1").val(tot_leader1);
        $("#tempo_id_unidad_leader1").val(datosLeader1[7]);
        $("#tempo_precioc_leader1").val(datosLeader1[8]);
        $("#tempo_preciov_leader1").val(datosLeader1[9]); 


        datosLeader2=document.getElementById('id_producto_leader2').value.split('_');

        $("#tempo_id_producto_leader2").val(datosLeader2[10]);

        $("#etiqueta_leader2").val(datosLeader2[1]);
        $("#ancho_leader2").val(datosLeader2[2]);
        $("#largo_leader2").val(datosLeader2[3]);
        $("#largo_leader2_original").val(datosLeader2[3]);
        unidad_leader2=datosLeader2[5]+'²';
        $("#unidad_leader2").val(unidad_leader2);  
        $("#leader2").val(datosLeader2[6]);      
        tot_leader2=$("#ancho_leader2").val()*$("#largo_leader2").val();
        $("#total_leader2").val(tot_leader2);
        $("#tempo_id_unidad_leader2").val(datosLeader2[7]);
        $("#tempo_precioc_leader2").val(datosLeader2[8]);
        $("#tempo_preciov_leader2").val(datosLeader2[9]); 

        datosLeader3=document.getElementById('id_producto_leader3').value.split('_');

        $("#tempo_id_producto_leader3").val(datosLeader3[10]);

        $("#etiqueta_leader3").val(datosLeader3[1]);
        $("#ancho_leader3").val(datosLeader3[2]);
        $("#largo_leader3").val(datosLeader3[3]);
        $("#largo_leader3_original").val(datosLeader3[3]);
        unidad_leader3=datosLeader3[5]+'²';
        $("#unidad_leader3").val(unidad_leader3);  
        $("#leader3").val(datosLeader3[6]);      
        tot_leader3=$("#ancho_leader3").val()*$("#largo_leader3").val();
        $("#total_leader3").val(tot_leader3);
        $("#tempo_id_unidad_leader3").val(datosLeader3[7]);
        $("#tempo_precioc_leader3").val(datosLeader3[8]);
        $("#tempo_preciov_leader3").val(datosLeader3[9]); 

        datosSticker=document.getElementById('id_producto_sticker').value.split('_');

        $("#tempo_id_producto_sticker").val(datosSticker[0]);

        $("#etiqueta_sticker").val(datosSticker[1]);
        $("#cantidad_sticker").val(datosSticker[3]);
        $("#cantidad_sticker_original").val(datosSticker[3]);
        unidad_sticker=datosSticker[5];
        $("#unidad_sticker").val(unidad_sticker); 
        $("#sticker").val(datosSticker[6]);
        $("#tempo_id_unidad_sticker").val(datosSticker[7]);
        $("#tempo_precioc_sticker").val(datosSticker[8]);
        $("#tempo_preciov_sticker").val(datosSticker[9]);          


        datosProducto=document.getElementById('pid_producto_pt').value.split('_');
        $("#pancho_prod").val(datosProducto[2]);
        
    }

    function mostrarValores2()
    {   
        datosProducto2=document.getElementById('pid_producto_pt2').value.split('_');
        $("#pancho_prod2").val(datosProducto2[2]);



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
                at=parseFloat(amp)-parseFloat($("#total_desp").val());
                at=at.toFixed(3);
                rollos_materia_prima=Math.trunc(at/parseFloat(ancho));
                $("#rollos_materia_prima").val(rollos_materia_prima);

                //alert("ancho: "+ancho);
                //alert("Ancho materia prima: "+amp);
                //alert("Ancho total: "+at);
                //alert("Rollos materia prima: "+rollos_materia_prima);

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

                
                total_desp_corrida=parseFloat($("#ancho_mp").val())-(parseFloat(rollos_materia_prima)*parseFloat(ancho))-parseFloat(total_desp);
                total_desp_corrida=Number(total_desp_corrida.toFixed(3));
                $("#total_desp_corrida").val(total_desp_corrida);

                dt_corrida=parseFloat(total_desp_corrida)+parseFloat(total_desp);
                dt_corrida=Number(dt_corrida.toFixed(3));
                $("#dt_corrida").val(dt_corrida);

                // cantidades de materia prima
                largo_mp_necesario=parseFloat(largo)*parseFloat(corridas_materia_prima);
                $("#largo_mp_necesario").val(largo_mp_necesario);                

                total_largo_restante=parseFloat($("#largo_mp").val())-largo_mp_necesario;
                $("#total_largo_restante").val(total_largo_restante);                

                mprollos[cont]   = cantidad;
                anchorollo[cont] = ancho*$("#rollos_materia_prima").val();
                largorollo[cont] = $("#largo_mp").val();
                despcorrida[cont] = ancho*$("#rollos_materia_prima").val();
                rolloscorrida[cont] = $("#rollos_materia_prima").val();

                // cantidades de core

                
                cantidad_core_necesario=parseFloat($("#rollos_totales").val());
                $("#cantidad_core_necesario").val(cantidad_core_necesario);                

                cantidad_core_restante=parseFloat($("#cantidad_core_original").val())-parseFloat(cantidad_core_necesario);
                $("#cantidad_core_restante").val(cantidad_core_restante); 


                // cantidades de leader1
                largo_leader1_necesario=parseFloat($("#corridas_materia_prima").val());
                $("#largo_leader1_necesario").val(largo_leader1_necesario);                

                largo_leader1_restante=parseFloat($("#largo_leader1_original").val())-parseFloat(largo_leader1_necesario);
                $("#largo_leader1_restante").val(largo_leader1_restante); 

                // cantidades de leader2
                largo_leader2_necesario=parseFloat($("#corridas_materia_prima").val());
                $("#largo_leader2_necesario").val(largo_leader2_necesario);                

                largo_leader2_restante=parseFloat($("#largo_leader2_original").val())-parseFloat(largo_leader2_necesario);
                $("#largo_leader2_restante").val(largo_leader2_restante); 

                // cantidades de leader3
                largo_leader3_necesario=parseFloat($("#corridas_materia_prima").val());
                $("#largo_leader3_necesario").val(largo_leader3_necesario);                

                largo_leader3_restante=parseFloat($("#largo_leader3_original").val())-parseFloat(largo_leader3_necesario);
                $("#largo_leader3_restante").val(largo_leader3_restante); 

                // cantidades de sticker
                cantidad_sticker_necesario=parseFloat($("#rollos_totales").val());
                $("#cantidad_sticker_necesario").val(cantidad_sticker_necesario);                

                cantidad_sticker_restante=parseFloat($("#cantidad_sticker_original").val())-parseFloat(cantidad_sticker_necesario);
                $("#cantidad_sticker_restante").val(cantidad_sticker_restante); 



                var fila='<tr class="selected" id="fila'+cont+'"><td><button  id="b'+cont+'" type="button" class="btn btn-danger btn-simple btn-xs" onclick="eliminar('+cont+');"><i class="fa fa-times"></i></button></td>  <td><input type="hidden" name="id_producto_pt[]" value="'+idarticulo+'">'+articulo+'</td> <td><input type="hidden" name="ancho_producto_pt[]" value="'+ancho+'">'+ancho+'</td> <td><input type="hidden" name="largo_producto_pt[]" value="'+largo+'">'+largo+'</td> <td><input type="hidden" step="0.01" name="cantidad_pt[]" value="'+rollos_totales+'">'+rollos_totales+'</td> ';



                
                cont++;
                limpiar();
                
                //alert(v1+" "+subtot);
                
                $(document).ready(onSelectPtChange);

                $("#subtot").html(subtot);
                $("#total").html(total);
                evaluar();
                $('#detalles').append(fila);
                $("#panel1").hide();

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


function agregar2(){
        datosArticulo2=document.getElementById('pid_producto_pt2').value.split('_');
        idarticulo2=datosArticulo2[0];
        ancho2=datosArticulo2[2];
        largo2=datosArticulo2[3];
        
        articulo2=$("#pid_producto_pt2 option:selected").text();
        cantidad2=$("#pcantidad_pt2").val();
        total_ancho2=cantidad2*ancho2;
        //ancho=$("#pancho_pt").val();

 
                
        if(idarticulo2!="" && cantidad2!="" && cantidad2>0)
        {
                                                
                total_desp_corrida=parseFloat($("#total_desp_corrida").val())-parseFloat(ancho2);
                total_desp_corrida=Number(total_desp_corrida.toFixed(3));
                $("#total_desp_corrida").val(total_desp_corrida);

                dt_corrida=parseFloat($("#dt_corrida").val())-parseFloat(ancho2);
                dt_corrida=Number(dt_corrida.toFixed(3));
                $("#dt_corrida").val(dt_corrida);

                cantidad2=$("#corridas_materia_prima").val()*1;
                rollos_totales=parseFloat($("#rollos_totales").val())+parseFloat(cantidad2);
                $("#rollos_totales").val(rollos_totales);

                t=parseInt($("#rollos_materia_prima").val())+1;
                $("#rollos_materia_prima").val(t);

                
                mprollos[cont]   = cantidad2;
                anchorollo[cont] = parseFloat(ancho2);
                largorollo[cont] = $("#largo_mp").val();
                despcorrida[cont] = parseFloat(ancho2);
                rolloscorrida[cont] = 1;

                // cantidades de core
                cantidad_core_necesario=parseFloat($("#rollos_totales").val());
                $("#cantidad_core_necesario").val(cantidad_core_necesario);                

                cantidad_core_restante=parseFloat($("#cantidad_core_original").val())-parseFloat(cantidad_core_necesario);
                $("#cantidad_core_restante").val(cantidad_core_restante); 

                // cantidades de leader1
                largo_leader1_necesario=parseFloat($("#corridas_materia_prima").val());
                $("#largo_leader1_necesario").val(largo_leader1_necesario);                

                largo_leader1_restante=parseFloat($("#largo_leader1_original").val())-parseFloat(largo_leader1_necesario);
                $("#largo_leader1_restante").val(largo_leader1_restante); 

                // cantidades de leader2
                largo_leader2_necesario=parseFloat($("#corridas_materia_prima").val());
                $("#largo_leader2_necesario").val(largo_leader2_necesario);                

                largo_leader2_restante=parseFloat($("#largo_leader2_original").val())-parseFloat(largo_leader2_necesario);
                $("#largo_leader2_restante").val(largo_leader2_restante); 

                // cantidades de leader3
                largo_leader3_necesario=parseFloat($("#corridas_materia_prima").val());
                $("#largo_leader3_necesario").val(largo_leader3_necesario);                

                largo_leader3_restante=parseFloat($("#largo_leader3_original").val())-parseFloat(largo_leader3_necesario);
                $("#largo_leader3_restante").val(largo_leader3_restante); 

                // cantidades de sticker
                cantidad_sticker_necesario=parseFloat($("#rollos_totales").val());
                $("#cantidad_sticker_necesario").val(cantidad_sticker_necesario);                

                cantidad_sticker_restante=parseFloat($("#cantidad_sticker_original").val())-parseFloat(cantidad_sticker_necesario);
                $("#cantidad_sticker_restante").val(cantidad_sticker_restante); 



                var fila='<tr class="selected" id="fila'+cont+'"><td><button id="b'+cont+'" type="button" class="btn btn-danger btn-simple btn-xs" onclick="eliminar('+cont+');"><i class="fa fa-times"></i></button></td>  <td><input type="hidden" name="id_producto_pt2[]" value="'+idarticulo2+'">'+articulo2+'</td> <td><input type="hidden" name="ancho_producto_pt2[]" value="'+ancho2+'">'+ancho2+'</td> <td><input type="hidden" name="largo_producto_pt2[]" value="'+largo2+'">'+largo2+'</td> <td><input type="hidden" step="0.01" name="cantidad_pt2[]" value="'+cantidad2+'">'+cantidad2+'</td> ';

                caracteresfila=fila.length;
                
                if(cont == 0)
                    cont++;

                limpiar();
                
                //alert(v1+" "+subtot);
                
                
                evaluar();
                $('#detalles').append(fila);
                $("#panel2").hide();
         
        }
        else
        {
            alert("Error al ingresar la información del producto, favor de revisar.");
        }
    }



    function limpiar(){
        $("#pcantidad_pt").val("");
        $("#pancho_pt").val("");
    }

    function limpiar_mp(){
        $("#total_desp_corrida").val("");      //Desperdicio estra por corrida
        $("#dt_corrida").val("");              //Desperdicio total por corrida
        $("#rollos_materia_prima").val("");    //Rollos por corrida
        $("#corridas_materia_prima").val("");  //Corridas necesarias
        $("#rollos_totales").val("");          //Rollos totales
        $("#largo_mp_necesario").val("");      //Largo necesario
        $("#total_largo_restante").val("");    //Largo restante  

        $("#cantidad_sticker_restante").val("");    //Cantidad Sticker restante  
        $("#cantidad_sticker_necesario").val("");   //Cantidad Sticker necesario 

        $("#largo_leader3_restante").val("");    //Leader 3 (envoltura) restante
        $("#largo_leader3_necesario").val("");   //Leader 3 (envoltura) necesario 

        $("#largo_leader2_restante").val("");    //Leader 2 (final) restante
        $("#largo_leader2_necesario").val("");   //Leader 2 (final) necesario 

        $("#largo_leader1_restante").val("");    //Leader 1 (inicial) restante
        $("#largo_leader1_necesario").val("");   //Leader 1 (inicial) necesario 

        $("#cantidad_core_restante").val("");    //Cantidad Core restante  
        $("#cantidad_core_necesario").val("");   //Cantidad Core necesario 


    }

    function evaluar(){
        
        if($("#cantidad_sticker_restante").val() < 0)
                {
                    document.getElementById("cantidad_sticker_restante").style.color = '#FF0000';
                    document.getElementById("cantidad_sticker_restante").style.fontWeight="bold";
                }
                else
                    document.getElementById('cantidad_sticker_restante').style.color = '#000000';   
        
        if($("#cantidad_core_restante").val() < 0)
                {
                    document.getElementById("cantidad_core_restante").style.color = '#FF0000';
                    document.getElementById("cantidad_core_restante").style.fontWeight="bold";
                }
                else
                    document.getElementById('cantidad_core_restante').style.color = '#000000';   

        if($("#total_largo_restante").val() < 0)
                {
                    document.getElementById("total_largo_restante").style.color = '#FF0000';
                    document.getElementById("total_largo_restante").style.fontWeight="bold";
                }
                else
                    document.getElementById('total_largo_restante').style.color = '#000000';   


        if($("#largo_leader1_restante").val() < 0)
                {
                    document.getElementById("largo_leader1_restante").style.color = '#FF0000';
                    document.getElementById("largo_leader1_restante").style.fontWeight="bold";
                }
                else
                    document.getElementById('largo_leader1_restante').style.color = '#000000';   
        
        if($("#largo_leader2_restante").val() < 0)
                {
                    document.getElementById("largo_leader2_restante").style.color = '#FF0000';
                    document.getElementById("largo_leader2_restante").style.fontWeight="bold";
                }
                else
                    document.getElementById('largo_leader2_restante').style.color = '#000000';   
        
        if($("#largo_leader3_restante").val() < 0)
                {
                    document.getElementById("largo_leader3_restante").style.color = '#FF0000';
                    document.getElementById("largo_leader3_restante").style.fontWeight="bold";
                }
                else
                    document.getElementById('largo_leader3_restante').style.color = '#000000';   


        


        if (total>0 && $("#dt_corrida").val()<0.060 && $("#total_largo_restante").val()>=0 && $("#cantidad_core_restante").val()>=0 && $("#largo_leader1_restante").val()>=0 && $("#largo_leader2_restante").val()>=0 && $("#largo_leader3_restante").val()>=0 && $("#cantidad_sticker_restante").val()>=0)
        {
            $("#guardar").show();
        }
        else
        {
            $("#guardar").hide();   
        }

        if($("#dt_corrida").val()>0.060){
            $("#panel2").show();
            $("#pid_producto_pt2").change(mostrarValores2);
            $("#pid_producto_pt2").click(mostrarValores2);
        }
        else {
            
            if(caracteresfila>0){
                $("#panel2").show();    
            }
            else 
            {
                $("#panel2").hide();
            }
        }
        
        if(cont == 0)
        {
            $("#b0").show();
        }
        else
        {
            $("#b0").hide();
        }


    } 

    function evaluar_desp(){
        if ($("#total_desp").val()>0){
            $("#bt_add").show();
        }
        else
        {
            $("#bt_add").hide();
        }
    }

    function show(bloq) {
     obj = document.getElementById(bloq);
     obj.style.display = (obj.style.display=='none') ? 'block' : 'none';
    }


    function eliminar(index){
        /*
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
        

        mprollos[cont]   = rollos_totales;
        anchorollo[cont] = ancho*$("#rollos_materia_prima").val();
        largorollo[cont] = $("#largo_mp").val();
        
       

        alert("index = "+index);
        alert("Rollos totales = "+$("#rollos_totales").val());
        alert("Numero de rollos a restar = "+mprollos[index]);
        alert("Desperdicio extra por corrida = "+$("#total_desp_corrida").val());
        alert("Rollos = "+mprollos[index]);
        alert("Desperdicio que se sumara = "+despcorrida[index]);

         
         */


        if (index>0)
        {
            tlr=$("#total_largo_restante").val(); 
            $("#total_largo_restante").val(tlr); 
            
            rt=$("#rollos_totales").val()-mprollos[index]; 
            $("#rollos_totales").val(rt); 

            dec=parseFloat($("#total_desp_corrida").val())+parseFloat(despcorrida[index]);
            $("#total_desp_corrida").val(dec); 

            dc=parseFloat($("#dt_corrida").val())+parseFloat(despcorrida[index]); 
            $("#dt_corrida").val(dc); 

            rc=parseInt($("#rollos_materia_prima").val())-rolloscorrida[index];
            $("#rollos_materia_prima").val(rc);
            

            $("#fila" + index).remove();     
            cont--;

            evaluar();
            $(document).ready(onSelectMpChange);
            $(document).ready(onSelectPtChange);
            $(document).ready(onSelectLeader1Change);
            $(document).ready(onSelectLeader2Change);


            $("#panel1").hide();      
            $("#panel2").show(); 
            

        }
        else 
        {
            tlr=$("#total_largo_restante").val()-largorollo[index];
            $("#total_largo_restante").val(tlr);
            
            rt=$("#rollos_totales").val()-mprollos[index]; 
            $("#rollos_totales").val(rt); 

            dec=parseFloat($("#total_desp_corrida").val())+parseFloat(despcorrida[index]); 
            $("#total_desp_corrida").val(dec); 

            dc=parseFloat($("#dt_corrida").val())+parseFloat(despcorrida[index]); 
            $("#dt_corrida").val(dc); 

            rc=parseInt($("#rollos_materia_prima").val())-rolloscorrida[index];
            $("#rollos_materia_prima").val(rc);

            $("#fila" + index).remove();
            
            caracteresfila=0;
            evaluar();

            $(document).ready(onSelectMpChange);
            $(document).ready(onSelectPtChange);

            $("#panel1").show();      
            $("#panel2").hide();      
            

            limpiar_mp();
        }

        
    }

    function eliminar2(index){

        $("#fila2" + index).remove();
        evaluar();
        $(document).ready(onSelectMpChange);
        $(document).ready(onSelectPtChange);
        limpiar_mp();
    }


</script>
@endpush
                
@endsection





                        


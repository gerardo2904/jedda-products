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
                                            <input type="text" class="form-control" readonly id="orden" name="orden" value="{{ $op->orden }}">
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="form-group ">
                                            <label class="control-label" style="color: rgba(0,0,0);">Fecha</label>
                                            <input class="datepicker form-control" type="text" name="fecha_hora" id="fecha_hora" value="{{ $op->fecha_hora }}"/>
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
                

                    <div class="tab-pane" id="pill2">
                        <div class="panel panel-primary">
                            <div class="panel-body">

                                <div class="row" >
                                    <div class="col-sm-3">
                                        <div class="form-group label-floating">
                                            <label class="control-label" style="color: rgba(0,0,0);">Materia prima</label>
                                            <select class="form-control " name="id_producto_mp" id="id_producto_mp" data-live-search="true" data-style="btn-default">
                                                @foreach ($materiaprima as $materia)
                                                    <option value="{{ $materia->id }}_{{ $materia->etiqueta }}_{{ $materia->ancho_prod }}_{{ $materia->cantidad_prod }}_{{ $materia->formula }}_{{ $materia->unidad }}_{{ $materia->articulo }}_{{ $materia->id_unidad }}_{{ $materia->precioc }}_{{ $materia->preciov }}_{{$materia->id_product}}_{{$materia->largo}}">{{ $materia->articulo }}</option>
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
                                            <input type="text" readonly class="form-control" id="etiqueta_mp" name="etiqueta_mp" value="{{ old('etiqueta_mp')}}">
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
                            </div> 
                        </div>
                    </div>
                </div>

            </form>
       </div>
    </div>
</div>

@include('includes.footer')


@endsection





                        


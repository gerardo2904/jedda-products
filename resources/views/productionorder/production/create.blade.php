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

                        <div class="row" style="background: #FCE7D8;">
                            <div class="col-sm-2">
                                <div class="form-group ">
                                    <label class="control-label" style="color: rgba(0,0,0);">Orden de Producción</label>
                                    <input type="text" class="form-control" name="orden" value="{{ old('orden')}}">
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <div class="form-group ">
                                    <label class="control-label" style="color: rgba(0,0,0);">Fecha</label>
                                    <input class="datepicker form-control" type="text" name="fecha_hora" id="fecha_hora" value="{{ old('fecha_hora')}}"/>
                                </div>
                            </div>
                    
                            <div class="col-sm-6">
                                <div class="form-group ">
                                    <label class="control-label" style="color: rgba(0,0,0);">Cliente</label>
                                    <select class="form-control selectpicker" name="idcliente" id="idcliente" data-live-search="true" data-style="btn-primary">
                                        @foreach ($clientes as $cliente)
                                            <option value="{{ $cliente->id }}">{{ $cliente->name }}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="id_company" id="id_company" value="{{ auth()->user()->empresa_id}}">
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <div class="form-group ">
                                    <label class="control-label" style="color: rgba(0,0,0);">Orden de compra cliente</label>
                                    <input type="text" class="form-control" name="orden_cliente" value="{{ old('orden_cliente')}}">
                                </div>
                            </div>
                        </div>    

                        <div class="row" style="background: #FCE7D8;">
                            <div class="col-sm-12">
                                <div class="form-group ">
                                </div>
                            </div>
                        </div>    

                    </div>

                    <div class="tab-pane" id="pill2">

                        <div class="row" style="background: #D4FAEC;">
                            <div class="col-sm-3">
                                <div class="form-group label-floating">
                                    <label class="control-label">Materia prima</label>
                                    <select class="form-control selectpicker" name="id_producto_mp" id="id_producto_mp" data-live-search="true" data-style="btn-primary">
                                        @foreach ($materiaprima as $materia)
                                            <option value="{{ $materia->id }}_{{ $materia->etiqueta }}_{{ $materia->ancho_prod }}_{{ $materia->cantidad_prod }}_{{ $materia->formula }}_{{ $materia->unidad }}_{{ $materia->articulo }}">{{ $materia->articulo }}</option>
                                        @endforeach
                                    </select>                                  
                                    <input type="hidden" name="id_company" id="id_company" value="{{ auth()->user()->empresa_id}}">

                                    <input type="hidden" name="tempo_id_producto_mp" id="tempo_id_producto_mp" value="{{ old('tempo_id_producto_mp')}}">

                                    
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
                                    <input type="text" disabled class="form-control" id="largo_mp" name="largo_mp" value="{{ old('largo_mp')}}">
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

                                    <input type="hidden" name="tempo_id_producto_core" id="tempo_id_producto_core" value="{{ old('tempo_id_producto_core')}}">
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
                                    <input type="text" disabled class="form-control" id="cantidad_core" name="cantidad_core" value="{{ old('cantidad_core')}}">
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
                                    <input type="hidden" name="tempo_id_producto_leader1" id="tempo_id_producto_leader1" value="{{ old('tempo_id_producto_leader1')}}">
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
                                    <input type="hidden" name="tempo_id_producto_leader2" id="tempo_id_producto_leader2" value="{{ old('tempo_id_producto_leader2')}}">
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
                                    <input type="hidden" name="tempo_id_producto_leader3" id="tempo_id_producto_leader3" value="{{ old('tempo_id_producto_leader3')}}">
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
                                    <input type="hidden" name="tempo_id_producto_sticker" id="tempo_id_producto_sticker" value="{{ old('tempo_id_producto_sticker')}}">
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
                                    <input type="text" disabled class="form-control" id="cantidad_sticker" name="cantidad_sticker" value="{{ old('cantidad_sticker')}}">
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
                

                    <div class="tab-pane" id="pill3">

                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <div class="row">                
                                <div class="col-sm-2">
                                    <div class="form-group ">
                                        <label class="control-label">Desperdicio lado derecho</label>
                                        <input type="number" step="0.001" class="form-control" name="desp_der" id="desp_der" value="0.010" >
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group ">
                                        <label class="control-label">Desperdicio lado izquierdo</label>
                                        <input type="number" step="0.001" class="form-control" name="desp_izq" id="desp_izq"  value="0.010" >
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
                                        <label class="control-label">Desperdicio extra por corrida </label>
                                        <input type="number" step="0.001" disabled class="form-control" id="total_desp_corrida" name="total_desp_corrida" value="{{ old('total_desp_corrida')}}">
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group ">
                                        <label class="control-label">Desperdicio total por corrida </label>
                                        <input type="number" step="0.001" disabled class="form-control" id="dt_corrida" name="dt_corrida" value="{{ old('dt_corrida')}}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">                
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

                            <div class="row">                
                                <div class="col-sm-4">
                                    <div class="form-group ">
                                        <label class="control-label">Materia prima </label>
                                        <input type="text" disabled class="form-control" id="materia_prima" name="materia_prima" value="{{ old('materia_prima')}}">
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group ">
                                        <label class="control-label">Largo original </label>
                                        <input type="text" disabled class="form-control" id="largo_mp_original" name="largo_mp_original" value="{{ old('largo_mp_original')}}">
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group ">
                                        <label class="control-label">Largo necesario </label>
                                        <input type="text" disabled class="form-control" id="largo_mp_necesario" name="largo_mp_necesario" value="{{ old('largo_mp_necesario')}}">
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group ">
                                        <label class="control-label">Largo restante </label>
                                        <input type="text" disabled class="form-control" id="total_largo_restante" name="total_largo_restante" value="{{ old('total_largo_restante')}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                
                    
                        <div class="row">
                            <div class="panel panel-primary">
                                <div class="panel-body">
                                    <div id="panel1">
                                        <div class="col-sm-3">
                                            <div class="form-group" >
                                                <label class="control-label" style="color: rgba(0,0,0);">Artículo</label>
                                                <select class="form-control " name="pid_producto_pt" id="pid_producto_pt" data-live-search="true" data-style="btn-info">
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label class="control-label" style="color: rgba(0,0,0);">Ancho</label>
                                                <input type="number" disabled step="0.01" class="form-control" name="pancho_prod" id="pancho_prod"  >
                                            </div>
                                        </div>

                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label class="control-label" style="color: rgba(0,0,0);">Cantidad</label>
                                                <input type="number" step="0.01" class="form-control" name="pcantidad_pt" id="pcantidad_pt"  >
                                            </div>
                                        </div>

                                        <div class="col-sm-2">
                                            <div class="form-group label-floating">
                                                <button type="button" id="bt_add" class="btn btn-primary">Agregar</button>
                                            </div>
                                        </div>
                                    </div>
                             

                            <!--ESTE ES EL PANEL SI SOBRA MATERIAL DE UNA CORRIDA-->

                                    <div style="display:none;" id="panel2" >
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label class="control-label" style="color: rgba(0,0,0);">Artículo</label>
                                                <select class="form-control " name="pid_producto_pt2" id="pid_producto_pt2" data-live-search="true" data-style="btn-info">
                                                    
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label class="control-label" style="color: rgba(0,0,0);">Ancho</label>
                                                <input type="number" disabled step="0.01" class="form-control" name="pancho_prod2" id="pancho_prod2"  >
                                                <input type="hidden" step="0.01" class="form-control" name="pcantidad_pt2" id="pcantidad_pt2" value="1" >
                                            </div>
                                        </div>

                                        <div class="col-sm-2">
                                            <div class="form-group label-floating">
                                                <button type="button" id="bt_add2" class="btn btn-primary">Agregar</button>
                                            </div>
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
                                                </thead>
                                                <tfoot>
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
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
                    </div>

                <div class="tab-pane" id="pill4">

                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <div class="row">  
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

    function mostrarValores()
    {   
        desp_der=$("#desp_der").val();
        desp_izq=$("#desp_izq").val();
        total_desp=parseFloat(desp_der)+parseFloat(desp_izq);
        $("#total_desp").val(total_desp);

        datosMateria=document.getElementById('id_producto_mp').value.split('_');

        $("#tempo_id_producto_mp").val(datosMateria[0]);
                
        $("#etiqueta_mp").val(datosMateria[1]);
        $("#ancho_mp").val(datosMateria[2]);
        $("#largo_mp").val(datosMateria[3]);
        $("#largo_mp_original").val(datosMateria[3]);
        $("#formula").val(datosMateria[4]);
        unidad_mp=datosMateria[5]+'²';
        $("#unidad_mp").val(unidad_mp);        
        tot_mp=$("#ancho_mp").val()*$("#largo_mp").val();
        $("#total_mp").val(tot_mp);
        $("#materia_prima").val(datosMateria[6]);



        datosCore=document.getElementById('id_producto_core').value.split('_');

        $("#tempo_id_producto_core").val(datosCore[0]);

        $("#etiqueta_core").val(datosCore[1]);
        $("#cantidad_core").val(datosCore[3]);
        unidad_core=datosCore[5];
        $("#unidad_core").val(unidad_core);        


        datosLeader1=document.getElementById('id_producto_leader1').value.split('_');

        $("#tempo_id_producto_leader1").val(datosLeader1[0]);

        $("#etiqueta_leader1").val(datosLeader1[1]);
        $("#ancho_leader1").val(datosLeader1[2]);
        $("#largo_leader1").val(datosLeader1[3]);
        unidad_leader1=datosLeader1[5]+'²';
        $("#unidad_leader1").val(unidad_leader1);        
        tot_leader1=$("#ancho_leader1").val()*$("#largo_leader1").val();
        $("#total_leader1").val(tot_leader1);


        datosLeader2=document.getElementById('id_producto_leader2').value.split('_');

        $("#tempo_id_producto_leader2").val(datosLeader2[0]);

        $("#etiqueta_leader2").val(datosLeader2[1]);
        $("#ancho_leader2").val(datosLeader2[2]);
        $("#largo_leader2").val(datosLeader2[3]);
        unidad_leader2=datosLeader2[5]+'²';
        $("#unidad_leader2").val(unidad_leader2);        
        tot_leader2=$("#ancho_leader2").val()*$("#largo_leader2").val();
        $("#total_leader2").val(tot_leader2);

        datosLeader3=document.getElementById('id_producto_leader3').value.split('_');

        $("#tempo_id_producto_leader3").val(datosLeader3[0]);

        $("#etiqueta_leader3").val(datosLeader3[1]);
        $("#ancho_leader3").val(datosLeader3[2]);
        $("#largo_leader3").val(datosLeader3[3]);
        unidad_leader3=datosLeader3[5]+'²';
        $("#unidad_leader3").val(unidad_leader3);        
        tot_leader3=$("#ancho_leader3").val()*$("#largo_leader3").val();
        $("#total_leader3").val(tot_leader3);

        datosSticker=document.getElementById('id_producto_sticker').value.split('_');

        $("#tempo_id_producto_sticker").val(datosSticker[0]);

        $("#etiqueta_sticker").val(datosSticker[1]);
        $("#cantidad_sticker").val(datosSticker[3]);
        unidad_sticker=datosSticker[5];
        $("#unidad_sticker").val(unidad_sticker);        


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

                
                total_desp_corrida=parseFloat($("#ancho_mp").val())-(parseFloat(rollos_materia_prima)*parseFloat(ancho))-parseFloat(total_desp);
                total_desp_corrida=Number(total_desp_corrida.toFixed(3));
                $("#total_desp_corrida").val(total_desp_corrida);

                dt_corrida=parseFloat(total_desp_corrida)+parseFloat(total_desp);
                dt_corrida=Number(dt_corrida.toFixed(3));
                $("#dt_corrida").val(dt_corrida);

                largo_mp_necesario=parseFloat(largo)*parseFloat(corridas_materia_prima);
                $("#largo_mp_necesario").val(largo_mp_necesario);                

                total_largo_restante=parseFloat($("#largo_mp").val())-largo_mp_necesario;
                $("#total_largo_restante").val(total_largo_restante);                

                mprollos[cont]   = cantidad;
                anchorollo[cont] = ancho*$("#rollos_materia_prima").val();
                largorollo[cont] = $("#largo_mp").val();
                despcorrida[cont] = ancho*$("#rollos_materia_prima").val();
                rolloscorrida[cont] = $("#rollos_materia_prima").val();


                var fila='<tr class="selected" id="fila'+cont+'"><td><button  id="b'+cont+'" type="button" class="btn btn-danger btn-simple btn-xs" onclick="eliminar('+cont+');"><i class="fa fa-times"></i></button></td>  <td><input type="hidden" name="id_producto_pt[]" value="'+idarticulo+'">'+articulo+'</td> <td><input type="hidden" name="ancho_producto_pt[]" value="'+ancho+'">'+ancho+'</td> <td><input type="hidden" name="largo_producto_pt[]" value="'+largo+'">'+largo+'</td> <td><input type="hidden" step="0.01" name="cantidad_pt[]" value="'+cantidad+'">'+cantidad+'</td> ';



                
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
    }

    function evaluar(){
        

        if (total>0 && $("#dt_corrida").val()<0.060)
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


<script>
    $('.datepicker').datepicker({
    weekStart:1
    });
</script>


@endsection

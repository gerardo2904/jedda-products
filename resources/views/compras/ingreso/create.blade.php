@extends('layouts.app')

@section('title','Jedda')

@section('body-class', 'product-page')

@section('content')

<div class="header header-filter" style="background-image: url('/img/imagen_principal2.png');">
            
</div>

		<div class="main main-raised">
			<div class="container">
		     	<div class="section">
	                <h2 class="title text-center">Registrar nueva orden de compra</h2>
                    
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form method="post" action="{{ url('admin/ingreso')}}">
                        {{ csrf_field() }}
                        
                    <div class="row">
                        <div class="col-sm-12">
                                <div class="form-group label-floating">
                                    <label class="control-label">Proveedor</label>
                                    <select class="form-control selectpicker" name="idproveedor" id="idproveedor" data-live-search="true" data-style="btn-info">
                                        @foreach ($clientes as $cliente)
                                            <option value="{{ $cliente->id }}">{{ $cliente->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                        </div>
                    </div>
                        
                    <div class="row">

                        <div class="col-sm-4">
                                <div class="form-group label-floating">
                                    <label class="control-label">Tipo de comprobante</label>
                                    <select class="form-control" name="tipo_comporbante">
                                        <option value="Factura">Factura</option>
                                        <option value="Recibo">Recibo</option>
                                    </select>
                                </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group label-floating">
                                <label class="control-label">Serie de comprobante</label>
                                <input type="text" class="form-control" name="serie_comprobante" value="{{ old('serie_comprobante')}}">
                            </div>
                        </div>
                        
                        <div class="col-sm-4">
                            <div class="form-group label-floating">
                                <label class="control-label">Número de comprobante</label>
                                <input type="text" class="form-control" name="num_comprobante" required value="{{ old('num_comprobante')}}">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="panel panel-primary">
                            <div class="panel-body">
                                <div class="col-sm-3">
                                    <div class="form-group label-floating">
                                    <label class="control-label">Artículo</label>
                                    <select class="form-control selectpicker " name="pidarticulo" id="pidarticulo" data-live-search="true" data-style="btn-info">
                                        @foreach ($products as $articulo)
                                            <option value="{{ $articulo->id }}">{{ $articulo->articulo }}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>
                                
                                <div class="col-sm-3">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Cantidad</label>
                                        <input type="number" class="form-control" name="pcantidad" id="pcantidad" required >
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group label-floating">
                                        <label class="control-label">precio de compra</label>
                                        <input type="number" class="form-control" name="pprecioc" id="pprecioc" required >
                                    </div>
                                </div>
                                    
                                <div class="col-sm-3">
                                    <div class="form-group label-floating">
                                        <button type="button" id="bt_add" class="btn btn-primary">Agregar</button>
                                    </div>
                                </div>


                            </div>
                        </div>

                         <div class="col-sm-6">
                            <div class="form-group label-floating">  
                                <button class="btn btn-primary">Registro de la orden de compra</button>
                                <a href="{{url('/compras/ingreso')}}" class="btn btn-default">Cancelar</a>
                            </div>
                        </div>
                    </div>
                        
                    </form>
					

	            </div>
	        </div>

		</div>

	    @include('includes.footer')

@endsection

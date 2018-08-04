@extends('layout')


@section('content')
					
					
	<div class="name">
		<h3 class="title">Orden de salida con {{ $venta->tipo_comprobante.'-'.$venta->serie_comprobante.'-'.$venta->num_comprobante }}</h3>
    </div>

    <div class="row">
        <div class="col-sm-2">
            <p> {{$venta->fecha_hora}} </p>
        </div>
        <div class="col-sm-2">
            <p>Cliente {{ $venta->name }}</p>
        </div>
        <div class="col-sm-2">
            <p>Notas: {{ $venta->notas }}</p>
        </div>

    </div>

	
			
    <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
        <thead style="background-color:#A9D0F5">
            <tr>
            <th>Artículo</th>
            <th>Cantidad</th>
            <th>Precio de venta</th>
            <th>Subtotal</th>
            </tr>
        </thead>
        
        <tbody>
            @foreach($detalles as $det)
                <tr>
                <td>{{$det->articulo}} {{$det->description}}  Lote: {{$det->etiqueta}} Notas: {{$venta->notas}}</td>
                <td>{{$det->cantidad}}</td>
                <td>{{$det->preciov}}</td>
                <td>{{$det->cantidad*$det->preciov}}</td>
                </tr>
            @endforeach
        </tbody>   

        <tfoot>
            <tr>
            <th></th>
            <th></th>
            <th>SUB-TOTAL</th>
            <th><h4 id="subtotal">{{$venta->total_venta}}</h4></th>
            <tr>
            <th></th>
            <th></th>    
            <th>IMPUESTO</th>
            <th><h4 id="impuesto">{{$venta->total_venta*$venta->impuesto*0.01}}</h4></th>
            </tr>
            <tr>
            <th></th>
            <th></th>    
            <th>TOTAL</th>
            <th><h4 id="total">{{$venta->total_venta+($venta->total_venta*$venta->impuesto*0.01)}}</h4></th>
            </tr>
            </tr>
        </tfoot> 
    </table>
@endsection







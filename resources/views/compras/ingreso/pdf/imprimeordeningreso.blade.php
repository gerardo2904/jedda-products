@extends('layout')


@section('content')
					
					
	<div class="name">
		<h3 class="title">Orden de ingreso con {{ $ingreso->tipo_comprobante.'-'.$ingreso->serie_comprobante.'-'.$ingreso->num_comprobante }}</h3>
    </div>

    <div class="row">
        <div class="col-sm-2">
            <p> {{$ingreso->fecha_hora}} </p>
        </div>
        <div class="col-sm-2">
            <p>Proveedor {{ $ingreso->name }}</p>
        </div>
        <div class="col-sm-2">
            <p>Notas: {{ $ingreso->notas }}</p>
        </div>

    </div>

	
			
    <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
        <thead style="background-color:#A9D0F5">
            <tr>
            <th>Artículo</th>
            <th>Cantidad</th>
            <th>Precio de compra</th>
            <th>Subtotal</th>
            </tr>
        </thead>
        
        <tbody>
            @foreach($detalles as $det)
                <tr>
                <td>{{$det->articulo}} {{$det->description}}</td>
                <td>{{$det->cantidad}}</td>
                <td>{{$det->precioc}}</td>
                <td>{{$det->cantidad*$det->precioc}}</td>
                </tr>
            @endforeach
        </tbody>   

        <tfoot>
            <tr>
            <th></th>
            <th></th>
            <th>SUB-TOTAL</th>
            <th><h4 id="subtotal">{{$ingreso->total}}</h4></th>
            <tr>
            <th></th>
            <th></th>    
            <th>IMPUESTO</th>
            <th><h4 id="impuesto">{{$ingreso->total*$ingreso->impuesto*0.01}}</h4></th>
            </tr>
            <tr>
            <th></th>
            <th></th>    
            <th>TOTAL</th>
            <th><h4 id="total">{{$ingreso->total+($ingreso->total*$ingreso->impuesto*0.01)}}</h4></th>
            </tr>
            </tr>
        </tfoot> 
    </table>
@endsection







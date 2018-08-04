@extends('layouts.app')

@section('title','Panel de control App Shop')

@section('body-class', 'profile-page')

@section('content')
<div class="header header-filter" style="background-image: url('/img/imagen_principal2.png');"></div>

<div class="main main-raised">
	<div class="profile-content">
		<div class="container">
			<div class="row">
				<div class="profile">
					<div class="avatar">
						<img src="{{ '/images/clients/'.$venta->image }}" alt="Circle Image" class="img-circle img-responsive img-raised">
					</div>
					
					
					<div class="name">
						<h3 class="title">{{ $venta->name }}</h3>

					</div>
				</div>
			</div>
			<div class="description text-center">
				<p>{{ $venta->tipo_comprobante.'-'.$venta->serie_comprobante.'-'.$venta->num_comprobante }}</p>
                <br>
                <p>Invoice QB: {{ $venta->ordenq }}</p>
			</div>
			
			@if (session('notification'))
                        <div class="alert alert-success">
                            {{ session('notification') }}
                        </div>
                    @endif
					
				
                                <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                                    <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                                        <thead style="background-color:#A9D0F5">
                                            <th>Artículo</th>
                                            <th>Lote</th>
                                            <th>Notas</th>
                                            <th>Cantidad</th>
                                            <th>Precio de venta</th>
                                            <th>Subtotal</th>
                                        </thead>
                                        <tfoot>
                                        <tr>

                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th>SUB-TOTAL</th>
                                            <th><h4 id="subtotal">{{$venta->total_venta}}</h4></th>
                                            <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>    
                                            <th>IMPUESTO</th>
                                            <th><h4 id="impuesto">{{$venta->total_venta*$venta->impuesto*0.01}}</h4></th>
                                            </tr>
                                            <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>    
                                            <th>TOTAL</th>
                                            <th><h4 id="total">{{$venta->total_venta+($venta->total_venta*$venta->impuesto*0.01)}}</h4></th>
                                            </tr>
                                        </tr>
                                            
                                        

                                        </tfoot>
                                        <tbody>
                                            @foreach($detalles as $det)
                                            	<tr>
                                            		<td>{{$det->articulo}} {{$det->description}}</td>
                                                    <td>{{$det->etiqueta}}</td>
                                                    <td>{{$venta->notas}}</td>
                                            		<td>{{$det->cantidad}}</td>
                                            		<td>{{$det->preciov}}</td>
                                                    <td>{{$det->cantidad*$det->preciov}}</td>
                                            	</tr>
                                            @endforeach

                                        </tbody>    
                                        
                                    </table>
                                </div>
                                <a href="{{ route('imprimeordensalida.pdf',$venta->idventa)}}" class="btn btn-sm btn-primary">Descargar orden de salida en PDF</a>


		</div>
	</div>
</div>  



@include('includes.footer')

@endsection







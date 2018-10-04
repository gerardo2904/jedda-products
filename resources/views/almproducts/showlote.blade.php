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
					</div>
					<div class="name">
						<h3 class="title">Ingresos</h3>
					</div>
				</div>
			</div>

				<div class="row">                          
                        <table class="table">
                            <thead>
                                <tr>
									<th class="col-md-2 text-center">Fecha</th>
									<th class="col-md-2 text-center">Orden de Ingreso</th>
									<th class="col-md-2 text-center">Lote</th>
                                    <th class="col-md-5 text-center">Articulo</th>
                                    <th class="col-md-2 text-center">Cantidad/Largo</th>
									<th class="col-md-2 text-center">Precio de compra</th>
									<th class="col-md-2 text-center">Cantidad</th>

                                </tr>
                            </thead>
                            <tbody> 
								@foreach ($ps2 as $prod2)                             
                                <tr>
									<td class="text-center">{{ $prod2->fecha_hora }}</td>
                                    <td class="text-center">
									<a href="{{URL::action('IngresoController@show',$prod2->idingreso)}}" rel="tooltip" title="Detalles Orden de Ingreso" class="btn btn-sm btn-success">
									{{ $prod2->serie_comprobante }}-{{$prod2->num_comprobante}}
									</a>
									</td>
									<td class="text-center">{{ $prod2->etiqueta }}</td>
									<td class="text-center">{{ $prod2->articulo }}</td>
                                    <td class="text-center">{{ $prod2->cantidad_prod }}</td>
                                    <td class="text-center">{{ $prod2->precioc }} </td>
									<td class="text-center">{{ $prod2->cantidad }} </td>
                                    
                                </tr>
								@endforeach
                            </tbody>
                        </table>
			                
				</div>
				<br><br>
				  
				{{-- $contador=0; --}}  
				@foreach ($ph as $prod)
					{{-- 
					if (contador==0)
						$temporal = $prod->orden; 
					else {
						if ($temporal=$prod->orden)
						{
							echo "SI";
							$contador=0;
						}
						else {
							echo "NO";
							$contador++;
						}
					}
					

					--}}
					<h3 class="title">Orden de Producción {{$prod->orden}}</h3>
					{{$prod->fecha_hora}} <br>
					{{$prod->materia}} <br>
					Largo antes del corte: {{$prod->cantidad_antes}} <br>
					Largo despues del corte: {{$prod->cantidad_despues}} <br>
					

					<div class="row">                          
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="col-md-5 text-center">Articulo</th>
                                    <th class="col-md-1 text-center">Ancho</th>
                                    <th class="col-md-2 text-center">Largo</th>
                                    <th class="col-md-2 text-center">Formula</th>
									<th class="col-md-2 text-center">Cantidad</th>

                                </tr>
                            </thead>
                            <tbody>                              
                                <tr>
                                    <td class="text-center">{{ $prod->articulo }}</td>
                                    <td class="text-center">{{ $prod->ancho_prod }}</td>
                                    <td class="text-center">{{ $prod->cantidad_prod }}</td>
                                    <td class="text-center">{{ $prod->formula }}</td>
                                    <td class="text-center">{{ $prod->cantidad_pt }} </td>
                                    
                                </tr>
                            </tbody>
                        </table>
					</div>

				@endforeach

			<br>
			<br>

			@if (! empty($pv))
			
			<div class="row">
				<div class="profile">
					<div class="name">
			
						<h3 class="title"> Salidas </h3>
					</div>
				</div>
			</div>

			<div class="row">                          
                <table class="table">
                    <thead>
                        <tr>
							<th class="col-md-2 text-center">Fecha</th>
							<th class="col-md-2 text-center">Orden de Salida</th>
							<th class="col-md-2 text-center">Lote</th>
                            <th class="col-md-5 text-center">Articulo</th>
                            <th class="col-md-2 text-center">Cantidad/Largo</th>
 							<th class="col-md-2 text-center">Precio de venta</th>
							<th class="col-md-2 text-center">Cantidad</th>
                        </tr>
                    </thead>
                    <tbody> 
						@foreach ($pv2 as $prodv2)                             
                            <tr>
								<td class="text-center">{{ $prodv2->fecha_hora }}</td>
                                <td class="text-center">
								<a href="{{URL::action('VentaController@show',$prodv2->idventa)}}" rel="tooltip" title="Detalles Orden de Salida" class="btn btn-sm btn-success">
								{{ $prodv2->serie_comprobante }}-{{$prodv2->num_comprobante}}
								</a>
								</td>
								<td class="text-center">{{ $prodv2->etiqueta }}</td>
                                <td class="text-center">{{ $prodv2->articulo }}</td>
                                <td class="text-center">{{ $prodv2->cantidad_prod }}</td>
                                <td class="text-center">{{ $prodv2->preciov }} </td>
								<td class="text-center">{{ $prodv2->cantidad }} </td>
                            </tr>
						@endforeach
                    </tbody>
                </table>
			</div>
			<br><br>
			@endif


			<a href="{{ route('existencias.pdf') }}" class="btn btn-sm btn-primary">Descargar existencias de productos en PDF</a>
            
			@if (session('notification'))
                        <div class="alert alert-success">
                            {{ session('notification') }}
                        </div>
            @endif

			
					

		</div>
	</div>
</div>  



@include('includes.footer')

@endsection







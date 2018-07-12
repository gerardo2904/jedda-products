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
						<h3 class="title">Orden de Ingreso {{$ps->tipo_comprobante}}-{{$ps->serie_comprobante}}-{{$ps->num_comprobante}}</h3>
						{{$ps->fecha_hora}}
						<br>
					</div>
				</div>
			</div>

				<div class="row">                          
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="col-md-5 text-center">Articulo</th>
                                    <th class="col-md-1 text-center">Ancho</th>
                                    <th class="col-md-2 text-center">Cantidad/Largo</th>
                                    <th class="col-md-2 text-center">Formula</th>
									<th class="col-md-2 text-center">Precio de compra</th>

                                </tr>
                            </thead>
                            <tbody>                              
                                <tr>
                                    <td class="text-center">{{ $ps->articulo }}</td>
                                    <td class="text-center">{{ $ps->ancho_prod }}</td>
                                    <td class="text-center">{{ $ps->cantidad_prod }}</td>
                                    <td class="text-center">{{ $ps->formula }}</td>
                                    <td class="text-center">{{ $ps->precioc }} </td>
                                    
                                </tr>
                            </tbody>
                        </table>

			             <a href="{{ route('existencias.pdf') }}" class="btn btn-sm btn-primary">Descargar existencias de productos en PDF</a>
			                
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







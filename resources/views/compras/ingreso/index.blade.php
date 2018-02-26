@extends('layouts.app')

@section('title','Listado de compras.')

@section('body-class', 'product-page')

@section('content')

<div class="header header-filter" style="background-image: url('/img/imagen_principal2.png');">
          
</div>
        @if (session('status'))
        <div class="alert alert-success">
        {{ session('status') }}
        </div>
        @endif

		<div class="main main-raised">
			<div class="container">
		    	<div class="section text-center">


                     @if(Session::has('message'))
                        <div class="alert {{ (Session::get('status') == 'exito')?'alert-success':'alert-danger' }} alert-dismissible" role="alert">
                            {{Session::get('message')}}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            
                        </div>
                    @endif
                    
	                <h2 class="title">Ordenes de compra</h2>
                    @include('compras.ingreso.search')  



					<div class="team">
						<div class="row">
                          <a href="{{url('/compras/ingreso/create')}}" class="btn btn-primary btn-round">Nueva orden de compra</a>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center">Fecha</th>
                                    <th class="text-center">Proveedor</th>
                                    <th class="text-center">comprobante</th>
                                    <th class="text-right">Impuesto</th>
                                    <th class="text-right">Total</th>
                                    <th class="text-right">Estado</th>
                                    <th class="text-right">Opciones</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ingresos as $ing)
                                <tr>
                                    
                                    <td>{{ $ing->fecha_hora }}</td>
                                    <td>{{ $ing->name }}</td>
                                    <td>{{ $ing->tipo_comprobante.': '.$ing->serie_comprobante.'-'.$ing->num_comprobante }}</td>
                                    <td>{{ $ing->impuesto }}</td>
                                    <td>{{ $ing->total }}</td>
                                    <td>{{ $ing->estado }}</td>

                                    <td>
                                        <a href="{{URL::action('IngresoController@show',$ing->idingreso)}}"><button class="btn btn-info btn-xs">Detalles</button></a>

                                        <a href="" data-target="#modal-delete-{{$ing->idingreso}}" data-toggle="modal"><button class="btn btn-danger btn-xs">Anular</button></a>
                                    </td>


                                </tr>
                                @include('compras.ingreso.modal')
                                @endforeach
                                
                            </tbody>
                        </table>
                           
			             {{ $ingresos->links()}}
			                
						</div>
					</div>

	            </div>
	        </div>

		</div>

	 @include('includes.footer')

@endsection

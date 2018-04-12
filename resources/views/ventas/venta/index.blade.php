@extends('layouts.app')

@section('title','Listado de ventas.')

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
                    
	                <h2 class="title">Ordenes de salida</h2>
                    @include('ventas.venta.search')  



					<div class="team">
						<div class="row">
                          <a href="{{url('/ventas/venta/create')}}" class="btn btn-primary btn-round">Nueva orden de salida</a>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center">Fecha</th>
                                    <th class="text-center">Cliente</th>
                                    <th class="text-center">Compañia</th>
                                    <th class="text-center">Comprobante</th>
                                    <th class="text-right">Impuesto</th>
                                    <th class="text-right">Total</th>
                                    <th class="text-right">Estado</th>
                                    <th class="text-right">Opciones</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ventas as $vnt)
                                <tr>
                                    
                                    <td>{{ $vnt->fecha_hora }}</td>
                                    <td>{{ $vnt->name }}</td>
                                    <td>{{ $vnt->compan }}</td>
                                    <td>{{ $vnt->tipo_comprobante.': '.$vnt->serie_comprobante.'-'.$vnt->num_comprobante }}</td>
                                    <td>{{ $vnt->impuesto }}</td>
                                    <td>{{ $vnt->total_venta }}</td>
                                    <td>{{ $vnt->estado }}</td>

                                    <td class="td-actions text-right">

                                        <a href="{{URL::action('VentaController@show',$vnt->idventa)}}" rel="tooltip" title="Detalles" class="btn btn-info btn-simple btn-xs">
                                                <i class="fa fa-info"></i>
                                            </a>

                                           

                                        <a href="" data-target="#modal-delete-{{$vnt->idventa}}" data-toggle="modal"><button class="btn btn-danger btn-simple btn-xs"><i class="fa fa-times"></i></button></a>
                                    </td>


                                </tr>
                                @include('ventas.venta.modal')
                                @endforeach
                                
                            </tbody>
                        </table>
                           
			             {{ $ventas->links()}}
			                
						</div>
					</div>

	            </div>
	        </div>

		</div>

	 @include('includes.footer')

@endsection

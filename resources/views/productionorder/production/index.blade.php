@extends('layouts.app')

@section('title','Listado de Ordenes de Producción.')

@section('body-class', 'product-page')

@section('content')

<div class="header header-filter" style="background-image: url('/img/imagen_principal2.png');">
          
</div>
        @if (session('status'))
        <div class="alert alert-success">
        {{ session('status') }}
        </div>
        @endif

        // Se cargan los modals de cada una de las ordenes de salida...
        // Modals para cancelar ordenes... 
        // Llama a archivo modal.blade.php 
        // Se hace aqui porque tiene que estar fuera de container ...

        @foreach ($ordenesp as $ord)
            @include('productionorder.production.modal')
        @endforeach


		<div class="main main-raised">
			<div class="container">
		    	<div class="section text-center">


                     @if(Session::has('message'))
                        <div class="alert {{ (Session::get('status') == 'exito')?'alert-success':'alert-danger' }} alert-dismissible" role="alert">
                            {{Session::get('message')}}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            
                        </div>
                    @endif
                    
	                <h2 class="title">Ordenes de Producción</h2>
                    @include('productionorder.production.search')  



					<div class="team">
						<div class="row">
                          <a href="{{url('/productionorder/production/create')}}" class="btn btn-primary btn-round">Nueva orden de producción</a>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center">Fecha</th>
                                    <th class="text-center">Orden del Sistema</th>
                                    <th class="text-center">Cliente</th>
                                    <th class="text-center">Compañia</th>
                                    <th class="text-center">Orden del Cliente</th>
                                    <th class="text-right">Estado</th>
                                    <th class="text-right">Opciones</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ordenesp as $ord)
                                <tr>
                                    
                                    <td>{{ $ord->fecha_hora }}</td>
                                    <td>{{ $ord->orden }}</td>
                                    <td>{{ $ord->name }}</td>
                                    <td>{{ $ord->compan }}</td>
                                    <td>{{ $ord->orden_cliente }}</td>
                                    <td>{{ $ord->estado }}</td>

                                    <td class="td-actions text-right">

                                        <a href="{{URL::action('ProductionOrderController@show',$ord->id_production)}}" 
                                            rel="tooltip" title="Detalles" class="btn btn-info btn-simple btn-xs">
                                                <i class="fa fa-info"></i>
                                            </a>

                                        <a href = "{{ url('/productionorder/production/'.$ord->id_production.'/edit')}}" rel="tooltip" title="Editar Orden de Producción" class="btn btn-success btn-simple btn-xs">
                                            <i class="fa fa-edit"></i>
                                        </a>

                                         @if($ord->estado == "A")
                                            <a href="" data-target="#modal-delete-{{$ord->id_production}}" data-toggle="modal"><button class="btn btn-danger btn-simple btn-xs"><i class="fa fa-times"></i></button></a>
                                        @else
                                            <button class="btn btn-danger btn-simple btn-xs" disabled ><i class="fa fa-times"></i></button>
                                        @endif

                                    </td>


                                </tr>
                                @include('productionorder.production.modal')
                                @endforeach
                                
                            </tbody>
                        </table>
                           
			             {{ $ordenesp->links()}}
			                
						</div>
					</div>

	            </div>
	        </div>

		</div>

	 @include('includes.footer')

@endsection

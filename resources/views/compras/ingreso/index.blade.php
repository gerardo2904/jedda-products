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

        // Se cargan los modals de cada una de las ordenes de ingreso...
        // Modals para cancelar ordenes... 
        // Llama a archivo modal.blade.php 
        // Se hace aqui porque tiene que estar fuera de container ...

        @foreach ($ingresos as $ing)
            @include('compras.ingreso.modal')
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
                    
	                <h2 class="title">Ordenes de ingreso</h2>
                    @include('compras.ingreso.search')  

					<div class="team">
						<div class="row">
                          <a href="{{url('/compras/ingreso/create')}}" class="btn btn-primary btn-round"><i class="fa fa-plus-square-o" aria-hidden="true"></i> Nueva orden de ingreso</a>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center">Fecha</th>
                                    <th class="text-center">Proveedor</th>
                                    <th class="text-center">Compañia</th>
                                    <th class="text-center">Comprobante</th>
                                    <th class="text-center">Orden Prod</th>
                                    <th class="text-center">Total</th>
                                    <th class="text-center">Estado</th>
                                    <th class="text-center">Opciones</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ingresos as $ing)
                                <tr>
                                    
                                    <td>{{ $ing->fecha_hora }}</td>
                                    <td>{{ $ing->name }}</td>
                                    <td>{{ $ing->compan }}</td>
                                    <td>{{ $ing->tipo_comprobante.': '.$ing->serie_comprobante.'-'.$ing->num_comprobante }}</td>
                                    <td>{{ $ing->ordenp }}</td>
                                    <td>{{ $ing->total }}</td>
                                    <td>{{ $ing->estado === "A" ? "Activa" : ($ing->estado === "F" ? "Finalizada" : "Cancelada") }}</td>

                                    <td class="td-actions text-right">
                                        <a href="{{URL::action('IngresoController@show',$ing->idingreso)}}" rel="tooltip" title="Detalles" class="btn btn-info btn-simple btn-xs">
                                            <i class="fa fa-info"></i>
                                        </a>
                                        <a href = "{{ url('/compras/ingreso/'.$ing->idingreso.'/edit')}}" rel="tooltip" title="Editar Orden de Ingreso" class="btn btn-success btn-simple btn-xs">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        @if($ing->estado == "A")
                                            <a href="" data-target="#modal-delete-{{$ing->idingreso}}" data-toggle="modal"><button class="btn btn-danger btn-simple btn-xs"><i class="fa fa-times"></i></button></a>
                                        @else
                                            <button class="btn btn-danger btn-simple btn-xs" disabled ><i class="fa fa-times"></i></button>
                                        @endif
                                    </td>
                                </tr>

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


@extends('layouts.app')

@section('title','Listado de productos.')

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

                    

                <div class="row">
                    <div class="col-sm-2">
                        <img style="width:150px; height:130px;" src="{{ $cim }}" alt="Rounded Raised" class="img-rounded img-responsive img-raised">
                    </div>
                    <div class="col-sm-10">
                        <h3 class="title text-left">Productos en almacen {{ $cia->name }} </h3>
                        
                    </div>
                </div>
                @include('almproducts.searchlote') 

					<div class="team">
						<div class="row">
                          
                        <table class="table">
                            <thead>
                                <tr>
                                    <!-- <th class="text-center">#</th> -->
                                    <th class="col-md-2 text-center">Nombre</th>
                                    <th class="col-md-2 text-center">Lote</th>
                                    <th class="col-md-4 text-center">Descripción</th>
                                    <th class="col-md-4 text-center">Cantidad/Largo</th>
                                    <th class="col-md-4 text-center">Existencia</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                <tr>
                                    <!-- <td class="text-center">{{ $product->id }}</td> -->
                                    <td>{{ $product->name }}</td>
                                    
                                    <td>
                                    <a href="{{URL::action('Admin\AlmproductController@showlote',[urlencode($product->etiqueta_prod),$cia->id])}}" class="btn btn-sm btn-primary" rel="tooltip" title="Historial">
                                    

                                    {{ $product->etiqueta_prod }}
                                    </a>
                                    </td>
                                    
                                    <td>{{ $product->description }}</td>
                                    <td>{{ $product->cantidad_prod }}</td>
                                    <td>{{ $product->existencia}}</td>
                                    
                                </tr>
                                @endforeach
                                
                            </tbody>
                        </table>

                        
                           
			             <a href="{{ route('existencias.pdf') }}" class="btn btn-sm btn-primary">Descargar existencias de productos en PDF</a>
			                
						</div>
					</div>

	            </div>
	        </div>

		</div>

	 @include('includes.footer')

@endsection

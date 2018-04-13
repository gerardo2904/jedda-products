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
                    
	                <h2 class="title">Productos disponibles</h2>
                    @include('admin.products.search') 

					<div class="team">
						<div class="row">
                          <a href="{{url('/admin/products/create')}}" class="btn btn-primary btn-round">Nuevo producto</a>
                        <table class="table">
                            <thead>
                                <tr>
                                    
                                    <th class="col-md-2 text-center">Nombre</th>
                                    <th class="col-md-4 text-center">Descripción</th>
                                    <th class="text-center">Categoría</th>
                                    <th class="text-center">Sub Categoría</th>
                                    <th class="text-right">Activo</th>
                                    <th class="text-right">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                <tr>
                                    
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->description }}</td>
                                    <td>{{ $product->categoria ? $product->categoria : 'General' }}</td>
                                    <td>{{ $product->subcategoria ? $product->subcategoria : 'General' }}</td>
                                    <td>{{ $product->activo ? 'Sí' : 'No' }}</td>
                                    <td class="td-actions text-right">
                                       <form method="post" action="{{ url('/admin/products/'.$product->id )}}">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                        
                                            <a href="{{url('/products/'.$product->id)}}" rel="tooltip" title="Ver Producto" class="btn btn-info btn-simple btn-xs">
                                                <i class="fa fa-info"></i>
                                            </a>
                                            
                                            <a href = "{{ url('/admin/products/'.$product->id.'/edit')}}" rel="tooltip" title="Editar producto" class="btn btn-success btn-simple btn-xs">
                                                <i class="fa fa-edit"></i>
                                            </a>
											
											<a href="{{url('/admin/products/'.$product->id.'/images')}}" rel="tooltip" title="Imágenes del Producto" class="btn btn-warning btn-simple btn-xs">
                                                <i class="fa fa-image"></i>
                                            </a>
											
                                            <button type="submit" rel="tooltip" title="Eliminar" class="btn btn-danger btn-simple btn-xs">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                                
                            </tbody>
                        </table>
                          
			             {{ isset($searchText) ? $products->appends(['searchText' => $searchText])->links() : $products->links()}}
                         
			                
						</div>
					</div>

	            </div>
	        </div>

		</div>

	 @include('includes.footer')

@endsection

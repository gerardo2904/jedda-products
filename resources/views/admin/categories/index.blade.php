@extends('layouts.app')

@section('title','Listado de categorias.')

@section('body-class', 'product-page')


@section('content')

<div class="header header-filter" style="background-image: url('/img/imagen_principal2.png');">
          
</div>
		<div class="main main-raised">
			<div class="container">
		    	<div class="section text-center">

                    @if(Session::has('message'))
                        <div class="alert {{ (Session::get('status') == 'exito')?'alert-success':'alert-danger' }} alert-dismissible" role="alert">
                            {{Session::get('message')}}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            
                        </div>
                    @endif



	                <h2 class="title">Categorias disponibles</h2>

					<div class="team">
						<div class="row">
                          <a href="{{url('/admin/categories/create')}}" class="btn btn-primary btn-round">Nueva categoría</a>
                        <table class="table">
                            <thead>
                                <tr>
                                    <!-- <th class="text-center">#</th> -->
                                    <th class="col-md-2 text-center">Nombre</th>
                                    <th class="col-md-5 text-center">Descripción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->description }}</td>
                                    <td class="td-actions text-right">
                                    <form method="post" action="{{ url('/admin/categories/'.$category->id )}}">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        
                                        <a href="{{url('/categories/'.$category->id)}}" rel="tooltip" title="Ver Categoría" class="btn btn-info btn-simple btn-xs">
                                            <i class="fa fa-info"></i>
                                        </a>
                                            
                                        <a href = "{{ url('/admin/categories/'.$category->id.'/edit')}}" rel="tooltip" title="Editar categoría" class="btn btn-success btn-simple btn-xs">
                                            <i class="fa fa-edit"></i>
                                        </a>
											
									    <a href="{{url('/admin/categories/'.$category->id.'/images')}}" rel="tooltip" title="Imágenes de Categoría" class="btn btn-warning btn-simple btn-xs">
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
                           
			             {{ $categories->links()}}
			                
						</div>
					</div>

	            </div>
	        </div>

		</div>

	 @include('includes.footer')

@endsection


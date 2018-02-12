@extends('layouts.app')

@section('title','Listado de Empresas.')

@section('body-class', 'product-page')

@section('content')

<div class="header header-filter" style="background-image: url('https://images.unsplash.com/photo-1423655156442-ccc11daa4e99?crop=entropy&dpr=2&fit=crop&fm=jpg&h=750&ixjsv=2.1.0&ixlib=rb-0.3.5&q=50&w=1450');">
          
</div>

		<div class="main main-raised">
			<div class="container">
		    	<div class="section text-center">
	                <h2 class="title">Empresas</h2>

					<div class="team">
						<div class="row">
                          <a href="{{url('/admin/companies/create')}}" class="btn btn-primary btn-round">Nueva empresa</a>
                        <table class="table">
                            <thead>
                                <tr>
                                    <!-- <th class="text-center">#</th> -->
                                    <th class="col-md-2 text-center">Nombre</th>
                                    <!-- <th class="text-center">Dirección</th> -->
                                    <th class="text-right">Ciudad</th>
                                    <!-- <th class="text-right">C.P.</th> -->
                                    <th class="text-right">Telefono</th>
                                    <th class="text-right">email</th>
                                    <th class="text-right">Contacto</th>
                                    <th class="text-right">Activo</th>
                                    <th class="text-right">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($companies as $company)
                                <tr>
                                    <!-- <td class="text-center">{{ $company->id }}</td> -->
                                    <td>{{ $company->name }}</td>
                                    <!-- <td>{{ $company->address }}</td>  -->
                                    <td>{{ $company->city }}</td>
                                    <!-- <td>{{ $company->cp }}</td> -->
                                    <td>{{ $company->tel }}</td>
                                    <td>{{ $company->email }}</td>
                                    <td>{{ $company->contact }}</td>
                                    <td>{{ $company->activo ? 'Sí' : 'No' }}</td>
                                    
                                    <td class="td-actions text-right">
                                       <form method="post" action="{{ url('/admin/companies/'.$company->id )}}">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                        
                                            <a href="#" rel="tooltip" title="Ver Empresa" class="btn btn-info btn-simple btn-xs">
                                                <i class="fa fa-info"></i>
                                            </a>
                                            
                                            <a href = "{{ url('/admin/companies/'.$company->id.'/edit')}}" rel="tooltip" title="Editar empresa" class="btn btn-success btn-simple btn-xs">
                                                <i class="fa fa-edit"></i>
                                            </a>
											
											<a href="{{url('/admin/companies/'.$company->id.'/images')}}" rel="tooltip" title="Imágenes de Empresa" class="btn btn-warning btn-simple btn-xs">
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
                           
			             {{ $companies->links()}}
			                
						</div>
					</div>

	            </div>
	        </div>

		</div>

	 @include('includes.footer')

@endsection

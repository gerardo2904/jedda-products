@extends('layouts.app')

@section('title','Listado de Clientes.')

@section('body-class', 'product-page')

@section('content')

<div class="header header-filter" style="background-image: url('/img/imagen_principal2.png');">
          
</div>

		<div class="main main-raised">
			<div class="container">
		    	<div class="section text-center">
	                <h2 class="title">Clientes</h2>

					<div class="team">
						<div class="row">
                          <a href="{{url('/admin/clients/create')}}" class="btn btn-primary btn-round">Nuevo cliente</a>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="col-md-2 text-center">Nombre</th>
                                    <th class="text-right">RFC</th>
                                    <th class="text-right">Email</th>
                                    <th class="text-right">Es proveedor</th>
                                    <th class="text-right">Activo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clients as $client)
                                <tr>
                                    <td>{{ $client->name }}</td>
                                    <td>{{ $client->rfc }}</td>
                                    <td>{{ $client->email }}</td>
                                    <td>{{ $client->es_proveedor == 1 ?'Sí':'No' }}</td>
                                    <td>{{ $client->activo == 1 ?'Sí':'No' }}</td>
                                    
                                    
                                    <td class="td-actions text-right">
                                       <form method="post" action="{{ url('/admin/clients/'.$client->id )}}">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                        
                                            <a href="{{url('/clients/'.$client->id)}}" rel="tooltip" title="Ver Cliente" class="btn btn-info btn-simple btn-xs">
                                                <i class="fa fa-info"></i>
                                            </a>
                                            
                                            <a href = "{{ url('/admin/clients/'.$client->id.'/edit')}}" rel="tooltip" title="Editar cliente" class="btn btn-success btn-simple btn-xs">
                                                <i class="fa fa-edit"></i>
                                            </a>
											
											<a href="{{url('/admin/clients/'.$client->id.'/images')}}" rel="tooltip" title="Imágenes de Cliente" class="btn btn-warning btn-simple btn-xs">
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
                           
			             {{ $clients->links()}}
			                
						</div>
					</div>

	            </div>
	        </div>

		</div>

	 @include('includes.footer')

@endsection

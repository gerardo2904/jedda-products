@extends('layouts.app')

@section('title','Listado de Usuarios.')

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

	                <h2 class="title">Usuarios</h2>

					<div class="team">
						<div class="row">
                          <a href="{{url('/admin/users/create')}}" class="btn btn-primary btn-round">Nuevo usuario</a>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="col-md-2 text-center">Nombre</th>
                                    <th class="text-right">Email</th>
                                    <th class="text-right">Perfil</th>
                                    <th class="text-right">Activo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                    <?php 
                                    // 0->admin 1->compras/ventas/produccion 2->produccion 3->rep
                                    if ($user->permisos == 0) 
                                        echo 'Administrador';
                                    if ($user->permisos == 1) 
                                        echo 'Compras/Ventas';
                                    if ($user->permisos == 2) 
                                        echo 'Producción';
                                    if ($user->permisos == 3) 
                                        echo 'Reportes';

                                    ?></td>
                                    <td>{{ $user->activo == 1 ?'Sí':'No' }}</td>
                                    
                                    
                                    <td class="td-actions text-right">
                                       <form method="post" action="{{ url('/admin/users/'.$user->id )}}">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                        
                                            <a href="{{url('/users/'.$user->id)}}" rel="tooltip" title="Ver Usuario" class="btn btn-info btn-simple btn-xs">
                                                <i class="fa fa-info"></i>
                                            </a>
                                            
                                            <a href = "{{ url('/admin/users/'.$user->id.'/edit')}}" rel="tooltip" title="Editar usuario" class="btn btn-success btn-simple btn-xs">
                                                <i class="fa fa-edit"></i>
                                            </a>
											
											<a href="{{url('/admin/users/'.$user->id.'/images')}}" rel="tooltip" title="Imágenes de Usuario" class="btn btn-warning btn-simple btn-xs">
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
                           
			             {{ $users->links()}}
			                
						</div>
					</div>

	            </div>
	        </div>

		</div>

	 @include('includes.footer')

@endsection

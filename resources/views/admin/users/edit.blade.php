@extends('layouts.app')

@section('title','Usuarios')

@section('body-class', 'product-page')

@section('content')

<div class="header header-filter" style="background-image: url('/img/imagen_principal2.png');">
            
        </div>

		<div class="main main-raised">
			<div class="container">
		     	<div class="section">
	                <h2 class="title text-center">Editar usuario seleccionado</h2>
                    
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form method="post" action="{{ url('admin/users/'.$user->id.'/edit')}}">
                        {{ csrf_field() }}
                        
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group label-floating">
                                <label class="control-label">Nombre de usuario</label>
                                <input type="text" class="form-control" name="name" value= "{{old('name',$user->name)}}">
                            </div>
                        </div>
                        
                        <div class="col-sm-6">
                            <div class="form-group label-floating">
                                <label class="control-label">Email</label>
                                <input type="email" class="form-control" name="email" value="{{old('email',$user->email)}}">
                            </div>
                        </div>
                    </div>

                    <div class="row">   
                        <div class="col-sm-6">
                            <div class="form-group label-floating">
                                <label class="control-label">Perfil</label>
                                <select class="form-control" name="permisos">
                                    @foreach ($lospermisos as $permiso)
                                        <option value="{{ $permiso->id }}" @if($permiso->id == old('permisos',$user->permisos)) selected @endif>
                                         {{ $permiso->name }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        
                        <div class="col-sm-6">
                            <div class="form-group label-floating">
                                <label class="control-label">Empresa</label>
                                <select class="form-control" name="empresa_id">
                                    @foreach ($lasempresas as $empresa)
                                        <option value="{{ $empresa->id }}" @if($empresa->id == old('empresa_id',$user->empresa_id)) selected @endif>
                                         {{ $empresa->name }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        
                        
                    </div>

                    


                    <div class="row">   
                        <div class="col-sm-6"> 
                            <div class="form-group label-gloating checkbox">
                                <label>
                                    <input type="checkbox" id="activo" name="activo"  {{ Is_null(old('activo',$user->activo)) ? "value=0":"value=1" }}  {{ $user->activo == 0 ? " ":"checked" }}>Activo
                                </label>
                            </div> 
                        </div>
                    </div>
                     
                    <input type="hidden" name="password" value={{"$user->password"}}>

                    <button class="btn btn-primary">Guardar cambios</button>
                    <a href="{{ url('/admin/users')}}" class="btn btn-default">Cancelar</a>
                        
                    </form>
					

	            </div>
	        </div>

		</div>

	@include('includes.footer')

@endsection

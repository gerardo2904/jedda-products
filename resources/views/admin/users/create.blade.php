@extends('layouts.app')

@section('title','Usuarios')

@section('body-class', 'product-page')

@section('content')

<div class="header header-filter" style="background-image: url('/img/imagen_principal2.png');">
            
        </div>

		<div class="main main-raised">
			<div class="container">
		     	<div class="section">
	                <h2 class="title text-center">Registrar nuevo usuario</h2>
                    
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form method="post" action="{{ url('admin/users')}}">
                        {{ csrf_field() }}
                        
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group label-floating">
                                <label class="control-label">Nombre de usuario</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name')}}">
                            </div>
                        </div>
                                
                        <div class="col-sm-6">
                            <div class="form-group label-floating">
                                <label class="control-label">Email</label>
                                <input type="email" class="form-control" name="email" value="{{ old('email')}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">    
                        <div class="col-sm-6">
                            <div class="form-group label-floating">
                                <label class="control-label">Password</label>
                                <input id="password" type="password" class="form-control" name="password"  required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group label-floating">
                                <label class="control-label">Perfil</label>
                                <select class="form-control" name="permisos">
                                    @foreach ($lospermisos as $permiso)
                                        <option value="{{ $permiso->id }}">{{ $permiso->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                        
                    <div class="row"> 
                        <div class="col-sm-6">
                            <div class="form-group label-floating">
                                <label class="control-label">Empresa</label>
                                <select class="form-control" name="empresa_id">
                                    @foreach ($lasempresas as $empresa)
                                        <option value="{{ $empresa->id }}">{{ $empresa->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group label-gloating checkbox">
                                <label>
                                    <input type="checkbox" name="activo" {{ old('activo',1) ? 'value=1 checked' : 'value=0' }}>Activo 
                                </label>
                            </div> 
                        </div>
                    </div>

                        <button class="btn btn-primary">Registro del usuario</button>
                        <a href="{{url('/admin/users')}}" class="btn btn-default">Cancelar</a>
                        
                    </form>
					

	            </div>
	        </div>

		</div>

	    @include('includes.footer')

@endsection

@extends('layouts.app')

@section('title','Empresas')

@section('body-class', 'product-page')

@section('content')

<div class="header header-filter" style="background-image: url('/img/imagen_principal2.png');">
            
        </div>

		<div class="main main-raised">
			<div class="container">
		     	<div class="section">
	                <h2 class="title text-center">Editar cliente seleccionada</h2>
                    
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form method="post" action="{{ url('admin/clients/'.$client->id.'/edit')}}">
                        {{ csrf_field() }}
                        
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group label-floating">
                                <label class="control-label">Nombre de cliente</label>
                                <input type="text" class="form-control" name="name" value= "{{old('name',$client->name)}}">
                            </div>
                        </div>
                        
                        <div class="col-sm-6">
                            <div class="form-group label-floating">
                                <label class="control-label">RFC</label>
                                <input type="text" class="form-control" name="rfc" value= "{{old('rfc',$client->rfc)}}">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group label-floating">
                                <label class="control-label">Dirección</label>
                                <input type="text" class="form-control" name="address" value= "{{old('address',$client->address)}}">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group label-floating">
                                <label class="control-label">Ciudad</label>
                                <input type="text" class="form-control" name="city" value= "{{old('city',$client->city)}}">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group label-floating">
                                <label class="control-label">C.P.</label>
                                <input type="text" class="form-control" name="cp" value= "{{old('cp',$client->cp)}}">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group label-floating">
                                <label class="control-label">Telefono</label>
                                <input type="text" class="form-control" name="tel" value= "{{old('tel',$client->tel)}}">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group label-floating">
                                <label class="control-label">Email</label>
                                <input type="text" class="form-control" name="email" value= "{{old('email',$client->email)}}">
                            </div>
                        </div>

                        

                        <div class="form-group label-gloating checkbox">
                            <label>
                                <input type="checkbox" id="activo" name="activo"  {{ Is_null(old('activo',$client->activo)) ? "value=0":"value=1" }}  {{ $client->activo == 0 ? " ":"checked" }}>Activo
                            </label>
                        </div> 
                       
                        <button class="btn btn-primary">Guardar cambios</button>
                        <a href="{{ url('/admin/clients')}}" class="btn btn-default">Cancelar</a>
                        
                    </form>
					

	            </div>
	        </div>

		</div>

	@include('includes.footer')

@endsection

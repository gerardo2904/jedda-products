@extends('layouts.app')

@section('title','Empresas')

@section('body-class', 'product-page')

@section('content')

<div class="header header-filter" style="background-image: url('/img/imagen_principal2.png');">
            
        </div>

		<div class="main main-raised">
			<div class="container">
		     	<div class="section">
	                <h2 class="title text-center">Registrar nueva empresa</h2>
                    
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form method="post" action="{{ url('admin/companies')}}">
                        {{ csrf_field() }}
                        
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group label-floating">
                                <label class="control-label">Nombre de compañia</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name')}}">
                            </div>
                        </div>
                                
                        <div class="col-sm-6">
                            <div class="form-group label-floating">
                                <label class="control-label">RFC de la compañia</label>
                                <input type="text" class="form-control" name="rfc" value="{{ old('rfc')}}">
                            </div>
                        </div>
                    </div>
                        
                            <div class="form-group label-floating">
                                <label class="control-label">Dirección</label>
                                <input type="text" class="form-control" name="address" value="{{ old('address')}}">
                            </div>
                        
                        
                            <div class="form-group label-floating">
                                <label class="control-label">Ciudad</label>
                                <input type="text" class="form-control" name="city" value="{{ old('city')}}">
                            </div>

                            <div class="form-group label-floating">
                                <label class="control-label">C.P.</label>
                                <input type="text" class="form-control" name="cp" value="{{ old('cp')}}">
                            </div>

                            <div class="form-group label-floating">
                                <label class="control-label">Telefono</label>
                                <input type="text" class="form-control" name="tel" value="{{ old('tel')}}">
                            </div>
                            
                            <div class="form-group label-floating">
                                <label class="control-label">Email</label>
                                <input type="text" class="form-control" name="email" value="{{ old('email')}}">
                            </div>
                            
                            <div class="form-group label-floating">
                                <label class="control-label">Contacto</label>
                                <input type="text" class="form-control" name="contact" value="{{ old('contact')}}">
                            </div>

<!--
                            <div class="form-group label-floating">
                                <label class="control-label">Activo</label>
                                <input type="checkbox" class="form-control" name="activo" value="{{ old('activo')}}" >  
                            </div>
-->
                            <div class="form-group label-gloating checkbox">
                                <label>
                                    <input type="checkbox" name="activo" {{ old('activo',1) ? 'value=1 checked' : 'value=0' }}>Activo 
                                </label>
                            </div> 


                           
                        
                        <button class="btn btn-primary">Registro del producto</button>
                        <a href="{{url('/admin/companies')}}" class="btn btn-default">Cancelar</a>
                        
                    </form>
					

	            </div>
	        </div>

		</div>

	    @include('includes.footer')

@endsection

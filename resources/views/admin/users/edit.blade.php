@extends('layouts.app')

@section('title','Empresas')

@section('body-class', 'product-page')

@section('content')

<div class="header header-filter" style="background-image: url('https://images.unsplash.com/photo-1423655156442-ccc11daa4e99?crop=entropy&dpr=2&fit=crop&fm=jpg&h=750&ixjsv=2.1.0&ixlib=rb-0.3.5&q=50&w=1450');">
            
        </div>

		<div class="main main-raised">
			<div class="container">
		     	<div class="section">
	                <h2 class="title text-center">Editar empresa seleccionada</h2>
                    
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form method="post" action="{{ url('admin/companies/'.$company->id.'/edit')}}">
                        {{ csrf_field() }}
                        
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group label-floating">
                                <label class="control-label">Nombre de compañia</label>
                                <input type="text" class="form-control" name="name" value= "{{old('name',$company->name)}}">
                            </div>
                        </div>
                        
                        <div class="col-sm-6">
                            <div class="form-group label-floating">
                                <label class="control-label">RFC</label>
                                <input type="text" class="form-control" name="rfc" value= "{{old('rfc',$company->rfc)}}">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group label-floating">
                                <label class="control-label">Dirección</label>
                                <input type="text" class="form-control" name="address" value= "{{old('address',$company->address)}}">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group label-floating">
                                <label class="control-label">Ciudad</label>
                                <input type="text" class="form-control" name="city" value= "{{old('city',$company->city)}}">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group label-floating">
                                <label class="control-label">C.P.</label>
                                <input type="text" class="form-control" name="cp" value= "{{old('cp',$company->cp)}}">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group label-floating">
                                <label class="control-label">Telefono</label>
                                <input type="text" class="form-control" name="tel" value= "{{old('tel',$company->tel)}}">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group label-floating">
                                <label class="control-label">Email</label>
                                <input type="text" class="form-control" name="email" value= "{{old('email',$company->email)}}">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group label-floating">
                                <label class="control-label">Contacto</label>
                                <input type="text" class="form-control" name="contact" value= "{{old('contact',$company->contact)}}">
                            </div>
                        </div>

                        <div class="form-group label-gloating checkbox">
                            <label>
                                <input type="checkbox" id="activo" name="activo"  {{ Is_null(old('activo',$company->activo)) ? "value=0":"value=1" }}  {{ $company->activo == 0 ? " ":"checked" }}>Activo
                            </label>
                        </div> 
                       
                        <button class="btn btn-primary">Guardar cambios</button>
                        <a href="{{ url('/admin/companies')}}" class="btn btn-default">Cancelar</a>
                        
                    </form>
					

	            </div>
	        </div>

		</div>

	@include('includes.footer')

@endsection

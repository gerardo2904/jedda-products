@extends('layouts.app')

@section('title','Bienvenidos a App Shop')

@section('body-class', 'product-page')

@section('content')

<div class="header header-filter" style="background-image: url('/img/imagen_principal2.png');">
            
        </div>

		<div class="main main-raised">
			<div class="container">
		     	<div class="section">
	                <h2 class="title text-center">Registrar nueva categoría</h2>
                    
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form method="post" action="{{ url('admin/categories')}}">
                        {{ csrf_field() }}
                        
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group label-floating">
                                <label class="control-label">Nombre de categoría</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name')}}">
                            </div>
                        </div>
                     </div>           
                        <div class="form-group label-floating">
                            <label class="control-label">Descripción</label>
                            <input type="text" class="form-control" name="description" value="{{ old('description')}}">
                        </div>
                    <div class="row">
                        <div class="form-group label-gloating checkbox">
                            <label>
                                <input type="checkbox" name="es_subcategoria" {{ old('es_subcateroria',0) ? 'value=1 checked' : 'value=0' }}>Es Subcategoria 
                            </label>
                        </div> 
                    </div>
                        
                       
                        <button class="btn btn-primary">Registro de categoría</button>
                        <a href="{{url('/admin/categories')}}" class="btn btn-default">Cancelar</a>
                        
                    </form>
					

	            </div>
	        </div>

		</div>

	    @include('includes.footer')

@endsection

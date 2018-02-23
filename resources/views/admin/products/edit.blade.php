@extends('layouts.app')

@section('title','Bienvenidos a App Shop')

@section('body-class', 'product-page')

@section('content')

<div class="header header-filter" style="background-image: url('/img/imagen_principal2.png');">
            
        </div>

		<div class="main main-raised">
			<div class="container">
		     	<div class="section">
	                <h2 class="title text-center">Editar producto seleccionado</h2>
                    
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form method="post" action="{{ url('admin/products/'.$product->id.'/edit')}}">
                        {{ csrf_field() }}
                        
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group label-floating">
                                <label class="control-label">Nombre del producto</label>
                                <input type="text" class="form-control" name="name" value= "{{old('name',$product->name)}}">
                            </div>
                        </div>
                                
                        <div class="col-sm-6">
                            <div class="form-group label-floating">
                                <label class="control-label">Precio del producto</label>
                                <input type="number" step="0.01" class="form-control" name="price" value= "{{old('price',$product->price)}}">
                            </div>
                        </div>
                    </div>
                        
                            
                        
                        <div class="row">
                            <div class="col-sm-6">
                            <div class="form-group label-floating">
                                <label class="control-label">Descripción corta</label>
                                <input type="text" class="form-control" name="description" value= "{{old('description',$product->description)}}">
                            </div>
                        </div>
                        
                        <div class="col-sm-6">
                            <div class="form-group label-floating">
                                <label class="control-label">Categoría del producto</label>
                                <select class="form-control" name="category_id">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @if($category->id == old('category_id',$product->category_id)) selected @endif>
                                         {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            </div>
                        </div>

                        
                            <textarea class="form-control" placeholder="Descrición extensa del producto" rows="5" name="long_description">{{old('long_description',$product->long_description)}}</textarea>
                            
                            <div class="form-group label-gloating checkbox">
                            <label>
                                <input type="checkbox" id="activo" name="activo"  {{ Is_null(old('activo',$product->activo)) ? "value=0":"value=1" }}  {{ $product->activo == 0 ? " ":"checked" }}>Activo
                            </label>
                        </div> 

                        <button class="btn btn-primary">Guardar cambios</button>
                        <a href="{{ url('/admin/products')}}" class="btn btn-default">Cancelar</a>
                        
                    </form>
					

	            </div>
	        </div>

		</div>

	@include('includes.footer')

@endsection

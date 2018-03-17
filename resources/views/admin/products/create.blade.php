@extends('layouts.app')

@section('title','Bienvenidos a App Shop')

@section('body-class', 'product-page')

@section('content')

<div class="header header-filter" style="background-image: url('/img/imagen_principal2.png');">
            
        </div>

		<div class="main main-raised">
			<div class="container">
		     	<div class="section">
	                <h2 class="title text-center">Registrar nuevo producto</h2>
                    
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form method="post" action="{{ url('admin/products')}}">
                        {{ csrf_field() }}
                        
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group label-floating">
                                <label class="control-label">Nombre del producto</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name')}}">
                            </div>
                        </div>
                                
                        <div class="col-sm-6">
                            <div class="form-group label-floating">
                                <label class="control-label">Descripción corta</label>
                                <input type="text" class="form-control" name="description" value="{{ old('description')}}">
                            </div>
                        </div>

                    </div>
                        
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Categoría del producto</label>
                                    <select class="form-control" name="category_id">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Sub Categoría del producto</label>
                                    <select class="form-control" name="subcategory_id">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row" style="background: #E0F2F7;">
                            <div class="col-sm-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Roll del producto</label>
                                    <select class="form-control" name="roll_id">
                                        @foreach ($roles as $roll)
                                            <option value="{{ $roll->id }}">{{ $roll->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row" style="background: #E0F2F7;">
                            <div class="col-sm-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Unidad de producción</label>
                                    <select class="form-control" id="id_unidad_prod" name="id_unidad_prod">
                                        @foreach ($unidades as $unidad)
                                            <option value="{{ $unidad->id }}">{{ $unidad->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Cantidad de producción (Length)</label>
                                    <input type="number" step="0.01" class="form-control" id="cantidad_prod" name="cantidad_prod" value="{{ old('cantidad_prod')}}">
                                </div>
                            </div>
                        </div>

                        <div class="row"  style="background: #E0F2F7;" >
                            <div class="col-sm-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Ancho(Width)</label>
                                    <input type="number" step="0.01" class="form-control" id="ancho_prod" name="ancho_prod" value="{{ old('ancho_prod')}}">
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group label-floating">
                                    <label class="control-label"></label>
                                    <input type="text"  disabled class="form-control" id="total_medida" name="total_medida" value="{{ old('total_medida')}}">
                                </div>
                            </div>

                        </div>

                        </div>

                            <textarea class="form-control form-group" placeholder="Descripción extensa del producto" rows="2" id="long_description" name="long_description">{{old('long_description')}}</textarea>

                            

                            

                            <div class="form-group label-gloating checkbox">
                                <label>
                                    <input type="checkbox" name="activo" {{ old('activo',1) ? 'value=1 checked' : 'value=0' }}>Activo 
                                </label>
                            </div> 
                            

                        <button class="btn btn-primary">Registro del producto</button>
                        <a href="{{url('/admin/products')}}" class="btn btn-default">Cancelar</a>
                        
                    </form>
					

	            </div>
	        </div>

		</div>

	    @include('includes.footer')

@push('scripts')
<script>
    $("#cantidad_prod").change(mostrarValores);
    $("#ancho_prod").change(mostrarValores);
    $("#total_medida").change(mostrarValores);

    function mostrarValores()
    {
        unidad=$("#id_unidad_prod option:selected").text();
        ancho=$("#ancho_prod").val();
        largo=$("#cantidad_prod").val();
        total=ancho*largo;
        if(total==0){
            total_texto='';
        }
        else{
        total_texto=total.toString()+' '+unidad+'²';
        }

        $("#total_medida").val(total_texto);

        
        
    }
</script>
@endpush


@endsection

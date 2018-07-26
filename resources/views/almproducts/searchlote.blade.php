{!! Form::Open(array('url'=>'/almproducts/lote','method'=>'GET','autocomplete'=>'off','role'=>'search')) !!}

<div class="form-group">
	<div class="input-group">
	    <div class="row">
        	<div class="col-sm-4">
				<input type="text" class="form-control" name="searchTextLote" placeholder="Buscar Lote..." value="{{$searchTextLote}}">
			</div>
			<div class="col-sm-4">
				<input type="text" class="form-control" name="searchTextName" placeholder="Buscar Producto..." value="{{$searchTextName}}">
			</div>
			<div class="col-sm-4">
				<span class="input-group-btn">
					<button type="submit" class="btn btn-primary">Buscar</button>
				</span>
			</div>
		</div>
	</div>
</div>

{{Form::close()}}
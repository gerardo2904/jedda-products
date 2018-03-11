@extends('layouts.app')

@section('title','Jedda')

@section('body-class', 'product-page')

@section('content')

<div class="header header-filter" style="background-image: url('/img/imagen_principal2.png');">
            
</div>

		<div class="main main-raised">
			<div class="container">
		     	<div class="section">
	                <h2 class="title text-center">Registrar nueva orden de compra</h2>
                    
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form method="post" action="{{ url('compras/ingreso')}}">
                        {{ csrf_field() }}

                        
                    <div class="row">
                        <div class="col-sm-12">
                                <div class="form-group label-floating">
                                    <label class="control-label">Proveedor</label>
                                    <select class="form-control selectpicker" name="idproveedor" id="idproveedor" data-live-search="true" data-style="btn-primary">
                                        @foreach ($clientes as $cliente)
                                            <option value="{{ $cliente->id }}">{{ $cliente->name }}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="id_empresa" id="id_empresa" value="{{ auth()->user()->empresa_id}}">
                                </div>
                        </div>
                    </div>
                        
                    <div class="row">

                        <div class="col-sm-2">
                                <div class="form-group label-floating">
                                    <label class="control-label">Tipo de comprobante</label>
                                    <select class="form-control" name="tipo_comprobante">
                                        <option value="Factura">Factura</option>
                                        <option value="Recibo">Recibo</option>
                                    </select>
                                </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group label-floating">
                                <label class="control-label">Serie de comprobante</label>
                                <input type="text" class="form-control" name="serie_comprobante" value="{{ old('serie_comprobante')}}">
                            </div>
                        </div>
                        
                        <div class="col-sm-2">
                            <div class="form-group label-floating">
                                <label class="control-label">Número de comprobante</label>
                                <input type="text" class="form-control" name="num_comprobante" required value="{{ old('num_comprobante')}}">
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group label-floating">
                                <label class="control-label">Impuesto</label>
                                <input type="number" class="form-control" name="impuesto" id="impuesto" required value="{{ old('impuesto','16')}}">
                            </div>
                        </div>

                    </div>
                    
                    <div class="row">
                        <div class="panel panel-primary">
                            <div class="panel-body">
                                <div class="col-sm-3">
                                    <div class="form-group label-floating">
                                    <label class="control-label">Artículo</label>
                                    <select class="form-control selectpicker " name="pidarticulo" id="pidarticulo" data-live-search="true" data-style="btn-primary">
                                        @foreach ($products as $articulo)
                                            <option value="{{ $articulo->id }}">{{ $articulo->articulo }}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>
                                
                                <div class="col-sm-3">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Cantidad</label>
                                        <input type="number" class="form-control" name="pcantidad" id="pcantidad"  >
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Precio</label>
                                        <input type="number" class="form-control" name="pprecioc" id="pprecioc"  >
                                    </div>
                                </div>
                                
     
                                <div class="col-sm-3">
                                    <div class="form-group label-floating">
                                        <button type="button" id="bt_add" class="btn btn-primary">Agregar</button>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                                <div class="form-group label-floating">
                                    <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                                        <thead style="background-color:#A9D0F5">
                                            <th>Opciones</th>
                                            <th>Artículo</th>
                                            <th>Cantidad</th>
                                            <th>Precio de compra</th>
                                            <th>Subtotal</th>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th>SUB-TOTAL</th>
                                            <th><h4 id="subtot">$ 0.00</h4></th>
                                        </tr>
                                            
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th>IMPUESTO</th>
                                            <th><h4 id="tax">$ 0.00</h4></th>
                                        </tr>

                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th>TOTAL</th>
                                            <th><h4 id="gt">$ 0.00</h4></th>
                                        </tr>


                                        </tfoot>
                                        <tbody>
                                            

                                        </tbody>    
                                        
                                    </table>
                                </div>
                                </div>


                            </div>
                        </div>

                         <div class="col-sm-6" id="guardar">
                            <div class="form-group label-floating">  
                                <button class="btn btn-primary" >Registro de la orden de compra</button>
                                <a href="{{url('/compras/ingreso')}}" class="btn btn-default">Cancelar</a>
                            </div>
                        </div>
                    </div>
                        
                    </form>
					

	            </div>
	        </div>

		</div>

	    @include('includes.footer')

@push('scripts')
<script>
    $(document).ready(function(){
        $('#bt_add').click(function(){
            agregar();
        });
    });

    var cont=0;
    total=0;
    tax=0;
    subtotal=[];
    subtot=0;
    gt=0;
    $("#guardar").hide();

    function agregar(){
        idarticulo=$("#pidarticulo").val();
        articulo=$("#pidarticulo option:selected").text();
        cantidad=$("#pcantidad").val();
        precioc=$("#pprecioc").val();
        
        

        if(idarticulo!="" && cantidad!="" && cantidad>0 && precioc!="")
        {
            subtotal[cont]=(cantidad*precioc);
            subtot=subtot+subtotal[cont];
            total=total+subtotal[cont];

            tax=tax+(($("#impuesto").val()*0.01)*subtotal[cont]);
            
            gt=subtot+tax;

            var fila='<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-danger btn-simple btn-xs" onclick="eliminar('+cont+');"><i class="fa fa-times"></i></button></td><td><input type="hidden" name="id_articulo[]" value="'+idarticulo+'">'+articulo+'</td><td><input type="number" name="cantidad[]" value="'+cantidad+'"></td><td><input type="number" name="precioc[]" value="'+precioc+'"></td> <td>'+subtotal[cont]+'</td> ';
            
            cont++;
            limpiar();
            $("#gt").html("$ "+gt);
            $("#subtot").html("$ "+subtot);
            $("#tax").html("$ "+tax);
            evaluar();
            $('#detalles').append(fila);
        }
        else
        {
            alert("Error al ingresar la información del producto, favor de revisar.");
        }

    }


    function limpiar(){
        $("#pcantidad").val("");
        $("#pprecioc").val("");
    }

    function evaluar(){
        if (total>0)
        {
            $("#guardar").show();
        }
        else
        {
            $("#guardar").hide();   
        }
    } 

    function eliminar(index){

        


        total=total-subtotal[index];
        
        subtot=subtot-subtotal[index];
        
        tax=tax-(($("#impuesto").val()*0.01)*subtotal[index]);
            
        gt=subtot+tax;
        
        $("#gt").html("$ "+gt);
        $("#subtot").html("$ "+subtot);
        $("#tax").html("$ "+tax);

        $("#fila" + index).remove();
        evaluar();
    }
</script>
@endpush

@endsection

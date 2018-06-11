@extends('layouts.app')

@section('title','Ordenes de Producción')

@section('body-class', 'profile-page')

@section('content')
<div class="header header-filter" style="background-image: url('/img/imagen_principal2.png');"></div>

<div class="main main-raised">
	<div class="profile-content">
		<div class="container">
			<div class="row">
				<div class="profile">
					<div class="avatar">
						<img src="{{ '/images/clients/'.$productionorder->image }}" alt="Circle Image" class="img-circle img-responsive img-raised">
					</div>
					
					
					<div class="name">
						<h3 class="title">{{ $productionorder->name }}</h3>

					</div>
				</div>
			</div>
			<div class="description text-center">
				<p>{{ $productionorder->direction }}</p>
			</div>

            <div>
                
                <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                    <thead style="background-color:#FFEEDD">
                        <th width="30%"><center><img src="{{ '/images/clients/'.$productionorder->image }}" class=" img-responsive img-raised"></center> </th>
                        <th width="50%"><center><h3>ORDEN DE PRODUCCIÓN </h3></center></th>
                        <th width="30%"><center><h4>Orden: {{ $productionorder->orden }} </h4></center></th>
                    </thead>
                    <tfoot>
                                        
                    </tfoot>
                    <tbody>
                        <tr>
                            <td width="30%">Fecha: {{ $productionorder->fecha_hora }}</td>
                            <td width="50%">Orden de Compra del cliente: {{ $productionorder->orden_cliente }}</td>
                            <td width="30%">Formula: {{ $productionorder->formula }}</td>
                        </tr>
                        <tr>
                            <td width="30%">LOTE: {{ $productionorder->etiqueta_mp }}</td>
                            <td width="50%">Materia prima utilizada: {{ $productionorder->name_materiaprima }}</td>
                            <td width="30%">Dirección: {{ $productionorder->direccion }}</td>
                        </tr>
                                            
                    </tbody>    
                                        
                </table>
            </div>

                <br>    

                {{$leader->name_leader1}}<br>
                {{$leader->name_leader2}}<br>
                {{$leader->name_leader3}}<br>
			
			@if (session('notification'))
                        <div class="alert alert-success">
                            {{ session('notification') }}
                        </div>
                    @endif
					
				
                                <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                                    <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                                        <thead style="background-color:#A9D0F5">
                                            <th>Artículo</th>
                                            <th>Descripción</th>
                                            <th>Medida</th>
                                            <th>Rollos</th>
                                        </thead>
                                        <tfoot>
                                        
                                        </tfoot>
                                        <tbody>
                                            @foreach($detalles as $det)
                                            	<tr>
                                            		<td>{{$det->articulo}}</td>
                                                    <td>{{$det->description}}</td>
                                                    <td>{{$det->ancho_prod}} X {{round($det->cantidad_prod)}}</td>
                                            		<td>{{$det->cantidad_pt}}</td>
                                            	</tr>
                                            @endforeach

                                        </tbody>    
                                        
                                    </table>
                                </div>


		</div>
	</div>
</div>  



@include('includes.footer')

@endsection







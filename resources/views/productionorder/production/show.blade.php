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
			
			@if (session('notification'))
                        <div class="alert alert-success">
                            {{ session('notification') }}
                        </div>
                    @endif
					
				
                                <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                                    <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                                        <thead style="background-color:#A9D0F5">
                                            <th>Artículo</th>
                                            <th>Cantidad</th>
                                        </thead>
                                        <tfoot>
                                        <tr>

                                            <th></th>
                                            <th></th>
                                            <th>.</th>
                                            <th><h4 id="cantidadmetros"> </h4></th>
                                            <tr>
                                            <th></th>
                                            <th></th>    
                                            <th>..</th>
                                            <th><h4 id="cantidadancho"> </h4></th>
                                            </tr>
                                            <tr>
                                            <th></th>
                                            <th></th>    
                                            <th>...</th>
                                            <th><h4 id="cantidadalcuadrado"> </h4></th>
                                            </tr>
                                        </tr>
                                            
                                        

                                        </tfoot>
                                        <tbody>
                                            @foreach($detalles as $det)
                                            	<tr>
                                            		<td>{{$det->articulo}}</td>
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







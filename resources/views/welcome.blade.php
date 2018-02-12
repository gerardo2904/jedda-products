@extends('layouts.app')

@section('title','Jedda - Inventario y producción')

@section('body-class', 'landing-page')

@section ('styles')
	<style>
		.team .row .col-md-4 {
			margin-bottom: 5em;
		}
		
		.row {
			display:   -webkit-box;
			display:   -webkit-flex;
			display:   -ms-flexbox;
			display:   flex;
			flex-wrap: wrap;
		}
		
		.row > [class*='col-'] {
			display: 		flex;
			flex-direction:	column;
		}
		
	</style>
@endsection

@section('content')

<div class="header header-filter" style="background-image: url('/img/ribbon.jpg');">
            <div class="container">
                <div class="row">
					<div class="col-md-6">
						<h1 class="title">Jedda.</h1>
	                    <h4>Sistema de inventarios y procucción.</h4>
					</div>
                </div>
            </div>
        </div>

		<div class="main main-raised">
			<div class="container">
		    	<div class="section text-center section-landing">
	                <div class="row">
	                    <div class="col-md-8 col-md-offset-2">
	                        <h2 class="title">Acceso rápido a productos</h2>
	                        <h5 class="description">Se muestran los productos como si fuera una tienda.</h5>
	                    </div>
	                </div>

					<div class="features">
						<div class="row">
		                    <div class="col-md-4">
								<div class="info">
									<div class="icon icon-primary">
										<i class="material-icons">chat</i>
									</div>
									<h4 class="info-title">Atendemos tus dudas</h4>
									<p>Atendemos rapidamente cualquier consulta que tengas via chat.</p>
								</div>
		                    </div>
		                    <div class="col-md-4">
								<div class="info">
									<div class="icon icon-success">
										<i class="material-icons">verified_user</i>
									</div>
									<h4 class="info-title">Pago seguro</h4>
									<p>Tus pedidos seran confirmados a traves de una llamada.</p>
								</div>
		                    </div>
		                    <div class="col-md-4">
								<div class="info">
									<div class="icon icon-danger">
										<i class="material-icons">fingerprint</i>
									</div>
									<h4 class="info-title">Informacion privada</h4>
									<p>Tu informacion esta a salvo y nunca sera compartida ni usada para otros propositos.</p>
								</div>
		                    </div>
		                </div>
					</div>
	            </div>

	        	<div class="section text-center">
	                <h2 class="title">Productos disponibles</h2>

					<div class="team">
						<div class="row">
                            
                            @foreach ($products as $product)
							<div class="col-md-4">
			                    <div class="team-player">
			                        <img src="{{$product->featured_image_url}}" alt="Thumbnail Image" class="img-raised img-circle">
			                        <h4 class="title">
									<a href="{{url('/products/'.$product->id)}}">{{$product->name}}</a> 
									<br>
										<small class="text-muted">{{$product->category_name}}</small>
									</h4>
			                        <p class="description">{{$product->description}}</p>
									
			                    </div>
			                </div>
                            @endforeach
			                
			                
						</div>
						
						<div class="text-center">
							{{ $products->links() }}
						</div>
					</div>

	            </div>


	        	<div class="section landing-section">
	                <div class="row">
	                    <div class="col-md-8 col-md-offset-2">
	                        <h2 class="text-center title">Contactanos</h2>
							<h4 class="text-center description">Por favor, dejanos tus comentarios y te contactaremos lo antes posible.</h4>
	                        <form class="contact-form">
	                            <div class="row">
	                                <div class="col-md-6">
										<div class="form-group label-floating">
											<label class="control-label">Nombre</label>
											<input type="text" class="form-control">
										</div>
	                                </div>
	                                <div class="col-md-6">
										<div class="form-group label-floating">
											<label class="control-label">Email</label>
											<input type="email" class="form-control">
										</div>
	                                </div>
	                            </div>

								<div class="form-group label-floating">
									<label class="control-label">Mensaje</label>
									<textarea class="form-control" rows="4"></textarea>
								</div>

	                            <div class="row">
	                                <div class="col-md-4 col-md-offset-4 text-center">
	                                    <button class="btn btn-primary btn-raised">
											Enviar comentarios
										</button>
	                                </div>
	                            </div>
	                        </form>
	                    </div>
	                </div>

	            </div>
	        </div>

		</div>

	   @include('includes.footer')
@endsection

@extends('layouts.app')

@section('title','Panel de control App Shop')

@section('body-class', 'profile-page')

@section('content')
<div class="header header-filter" style="background-image: url('/img/imagen_principal2.png');"></div>

<div class="main main-raised">
	<div class="profile-content">
		<div class="container">
			<div class="row">
				<div class="profile">
					<div class="avatar">
						<img src="{{ $company->featured_image_url }}" alt="Circle Image" class="img-circle img-responsive img-raised">
					</div>
					
					
					<div class="name">
						<h3 class="title">{{ $company->name }}</h3>
						<h4 class="title">{{ 'RFC '.$company->rfc }}</h4>

					</div>
				</div>
			</div>
			<div class="description text-center">
				<p>{{ $company->address.', '.$company->city }}</p>
				<p>{{ 'C.P. '. $company->cp.', Telefono '.$company->tel }}</p>
				<p>{{ 'Contacto '. $company->contact.', Email '.$company->email }}</p>
			</div>
			
			@if (session('notification'))
                        <div class="alert alert-success">
                            {{ session('notification') }}
                        </div>
                    @endif
					
				
			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<div class="profile-tabs">
						<div class="nav-align-center">
							

							<div class="tab-content gallery">
								<div class="tab-pane active" id="studio">
									<div class="row">
										<div class="col-md-6">
											@foreach ($imagesLeft as $image)
											<img src="{{ $image->url }}" class="img-rounded" />
											@endforeach
										</div>
										<div class="col-md-6">
											@foreach ($imagesRight as $image)
											<img src="{{ $image->url }}" class="img-rounded" />
											@endforeach
										</div>
									</div>
								</div>
								

							</div>
						</div>
					</div>
					<!-- End Profile Tabs -->
				</div>
			</div>

		</div>
	</div>
</div>  



@include('includes.footer')

@endsection







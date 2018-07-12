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
					
					</div>
					
					
					<div class="name">
						<h3 class="title">{{ $l }}</h3>
						<h6>{{ $i }}</h6>
					</div>
				</div>
			</div>
            
			@if (session('notification'))
                        <div class="alert alert-success">
                            {{ session('notification') }}
                        </div>
                    @endif
					

		</div>
	</div>
</div>  



@include('includes.footer')

@endsection







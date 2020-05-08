@extends('layouts.app')

@section('content')
    <div class="container">
		<div class="row mb-3">
			<div class="col">
				<a href="{{route('marcas.index')}}" class="btn btn-primary float-right">
					Volver al listado
				</a>
			</div>
		</div>
        <div class="row">
            <div class="col-lg-6 col-md-8 col-sm-12">
				<div class="card">
					<div class="card-header">
						<h5>Nueva marca</h5>
					</div>
					<div class="card-body">
		
						@include('partials.new-marca-form')

					</div>
				</div>
            </div>
        </div>
    </div>
@endsection
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-8 col-sm-12">
				<div class="card">
					<div class="card-header">
						<h5>Nueva marca</h5>
					</div>
					<div class="card-body">
						@if (Session::has('success'))
							<div class="alert alert-success">
								{{Session::get('success')}}
							</div>
						@endif
						@if (Session::has('error'))
							<div class="alert alert-danger">
								{{Session::get('error')}}
							</div>
						@endif
						
						@include('partials.new-marca-form')
	
						@if ($errors->any())
							<div class="form-group">
								<div class="alert alert-danger">
									{{$errors->first()}}
								</div>
							</div>
						@endif
					</div>
				</div>
            </div>
        </div>
    </div>
@endsection
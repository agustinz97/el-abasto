@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        Nuevo proveedor
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
						
						@include('partials.new-proveedor-form')
						
						@if ($errors->any())
							<div class="alert alert-danger">
								{{$errors->first()}}
							</div>
						@endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection
@extends('layouts.app')

@section('content')
    <div class="container">
		<div class="row mb-3">
			<div class="col">
				<a href="{{route('proveedores.index')}}" class="btn btn-primary float-right">
					Volver al Listado
				</a>
			</div>
		</div>
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        Nuevo proveedor
                    </div>
                    <div class="card-body">	
						
						@include('partials.new-proveedor-form')

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        Nuevo producto
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
                        <form action="{{route('productos.create')}}" method="POST">
							@csrf
							
							<div class="row">
								<div class="col-md-6 col-sm-12">
                                    <label for="marca">Proveedor</label>
                                    <div class="input-group mb-3">
										<select class="custom-select" required id="proveedor" name="proveedor">
											<option value="0">Seleccione el proveedor</option>
											@foreach($proveedores as $proveedor)
											<option value="{{$proveedor->id}}" {{old('proveedor') == $proveedor->id ? 'selected' : ''}}>
												{{$proveedor->name}}
											</option>
											@endforeach
										</select>
										<button 
											class="btn btn-primary ml-2" 
											data-toggle="modal" data-target="#modal-proveedor"
											id="btnProveedor"
											type="button">
											Nuevo +
										</button>
									</div>
								</div>

								<div class="col-md-6 col-sm-12">
                                    <label for="marca">Marca</label>
                                    <div class="input-group mb-3">
										<select class="custom-select" required id="marca" name="marca">
											<option value="0">Seleccione la marca</option>
											@foreach($marcas as $marca)
											<option value="{{$marca->id}}" {{old('marca') == $marca->id ? 'selected' : ''}}>
												{{$marca->name}}
											</option>
											@endforeach
										</select>
										<button 
											class="btn btn-primary ml-2" 
											data-toggle="modal" data-target="#modal-marca"
											id="btnMarca"
											type="button">
											Nueva +
										</button>
									</div>
								</div>
							</div>

                            <div class="row">
                                <div class="col-md-8 col-sm-12">
                                    <label for="name">Nombre del producto</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Nombre</span>
                                        </div>
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            id="name" name="name"
                                            value="{{old('name')}}"
                                            >
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    <label for="kg">Kg</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-apend">
                                            <span class="input-group-text">Kg</span>
                                        </div>
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            id="kg" name="kg"
                                            value="{{old('kg')}}"
                                            >
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 col-sm-12">
                                    <label for="price">Precio de compra</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">$</span>
                                        </div>
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            id="price" name="price"
                                            value="{{old('price')}}"
                                            >
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    <label for="discount">Descuento</label>
                                    <div class="input-group mb-3">
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            id="discount" name="discount"
                                            value="{{old('discount')}}">
                                        <div class="input-group-append">
                                          <span class="input-group-text">%</span>
                                        </div>
                                      </div>
                                </div>
                            </div>

                            {{-- <div class="row">

                                <div class="col-md-4 col-sm-12">
                                    <label for="stock">Stock incial</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-preppend">
                                            <span class="input-group-text">Stock</span>
                                        </div>
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            name="stock" id="stock"
                                            value="{{old('stock')}}">
                                      </div>
                                </div>
                            </div> --}}

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    {{$errors->first()}}
                                </div>
                            @endif
                            <div class="form-group">
                                <button class="btn btn-success float-right">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
	</div>
	
	<!-- Modal Nueva Marca -->
    <div class="modal fade" id="modal-marca" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Crear marca</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @include('partials.new-marca-form')
            </div>
        </div>
        </div>
	</div>
	
	<!-- Modal Nuevo Proveedor -->
    <div class="modal fade" id="modal-proveedor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Crear proveedor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @include('partials.new-proveedor-form')
            </div>
        </div>
        </div>
    </div>
@endsection
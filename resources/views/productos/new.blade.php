@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-8 col-sm-12">
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
                                <div class="col-8">
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
                                <div class="col-3">
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
                                <div class="col-4">
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
                                <div class="col-3">
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

                            <div class="row">

                                <div class="col-6">
                                    <label for="marca">Marca</label>
                                    <select class="custom-select" required id="marca" name="marca">
                                        <option value="0">Seleccione la marca</option>
                                        @foreach($marcas as $marca)
                                        <option value="{{$marca->id}}" {{old('marca') == $marca->id ? 'selected' : ''}}>
                                            {{$marca->name}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-4">
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
                            </div>

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
@endsection
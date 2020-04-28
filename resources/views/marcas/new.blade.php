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
                        <form action="{{route('marcas.create')}}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Nombre de la marca</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Nombre</span>
                                    </div>
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        id="name" name="name"
                                        value="{{old('name')}}"
                                        required>
                                </div>
                            </div>
                            <div class="form-group">
                                <select class="custom-select" required id="proveedor" name="proveedor">
                                    <option value="0">Seleccione un proveedor</option>
                                    @foreach($proveedores as $proveedor)
                                    <option value="{{$proveedor->id}}" {{old('proveedor') == $proveedor->id ? 'selected' : ''}}>
                                        {{$proveedor->name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            @if ($errors->any())
                            <div class="form-group">
                                <div class="alert alert-danger">
                                    {{$errors->first()}}
                                </div>
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
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
                        <form action="{{route('proveedores.create')}}" id="create-form" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Nombre del proveedor</label>
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
                                <label for="email">Correo electrónico</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Correo electrónico</span>
                                    </div>
                                    <input 
                                        type="email" 
                                        class="form-control" 
                                        id="email" name="email"
                                        value="{{old('email')}}"
                                        >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="phone">Teléfono</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Teléfono</span>
                                    </div>
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        id="phone" name="phone"
                                        value="{{old('phone')}}"
                                        >
                                </div>
                            </div>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    {{$errors->first()}}
                                </div>
                            @endif
                            <button class="btn btn-success mb-3">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection
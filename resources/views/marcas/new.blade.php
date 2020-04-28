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
                        <form action="" method="POST">
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
                                <button class="btn btn-success">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
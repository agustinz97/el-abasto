@extends('layouts.app')
    
@section('styles')
<style>
    .icon{
        font-size: 7rem;
        color: var(--primary);
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center p-3">
                    <div class="icon mb-3">
                        <i class="fas fa-tags"></i>
                    </div>
                    <a href="{{route('marcas.index')}}">Marcas</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center p-3">
                    <div class="icon mb-3">
                        <i class="fas fa-box-open"></i>
                    </div>
                    <a href="{{route('productos.index')}}">Productos</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center p-3">
                    <div class="icon mb-3">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <a href="{{route('proveedores.index')}}">Proveedores</a>
                </div>
            </div>
        </div>        
    </div>
</div>
@endsection

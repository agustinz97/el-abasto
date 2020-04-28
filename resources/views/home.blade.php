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
                    <a href="#">Productos</a>
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
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center p-3">
                    <div class="icon mb-3">
                        <i class="fas fa-user-friends"></i>
                    </div>
                    <a href="#">Clientes</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mt-3">
            <div class="card">
                <div class="card-body text-center p-3">
                    <div class="icon mb-3">
                        <i class="fas fa-box-open"></i>
                    </div>
                    <a href="#">Pedidos</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

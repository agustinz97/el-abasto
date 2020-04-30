@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-3">
            <div class="col-md-4">
                <h5>Listado de productos</h5>
            </div>
            <div class="col-md-8">
                <a href="{{route('productos.new')}}" class="btn btn-success float-right">Nuevo +</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 table-responsive">
                <table id="productos-table" class="table table-hover table-striped nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th width="10%">Marca</th>
                            <th width="20%">Nombre</th>
                            <th>Precio</th>
                            <th>Precio Kg</th>
                            <th>Precio minorista</th>
                            <th>Precio reventa</th>
                            <th>Precio mayorista</th>
                            <th width="10%">&nbsp;</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#productos-table').DataTable({
                "responsive": true,
                "serverside": true,
                "ajax": "{{route('datatables.productos')}}",
                "columns": [
                    {
                        data: 'id',
                        render: function (data, type, row){
                            return '#'+data.padStart(6, '0')
                        }
                    },
                    {data: 'marca.name'},
                    {data: 'format_name'},
                    {
                        data: 'base_price',
                        render: function (data, type, row){
                            return '$'+Number(data).toFixed(2)
                        }
                    },
                    {
                        data: 'kg_price',
                        render: function (data, type, row){
                            return '$'+Number(data).toFixed(2)
                        }
                    },
                    {
                        data: 'retail_price',
                        render: function (data, type, row){
                            return '$'+Number(data).toFixed(2)
                        }
                    },
                    {
                        data: 'resale_price',
                        render: function (data, type, row){
                            return '$'+Number(data).toFixed(2)
                        }
                    },
                    {
                        data: 'wholesale_price',
                        render: function (data, type, row){
                            return '$'+Number(data).toFixed(2)
                        }
                    },
                    {data: 'btn'},
                ] 
            });
        } );
    </script>
    <script>
        function remove(id){

            Swal.fire({
                title: '¿Seguro quieres eliminar?',
                text: "Esto no puede deshacerse",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar'
            })
            .then( async (result) => {
                if (result.value) {

                    const url = route('productos.delete', id)

                    try{
                        const response = await axios.delete(url)

                        Swal.fire(
                            'Eliminado!',
                            'El producto fue eliminado',
                            'success'
                        )

                        $('#productos-table').DataTable().ajax.reload()
                        
                    }catch{
                        console.error(error)
                    }
                    
                }
            })
  
        }
    </script>
@endsection
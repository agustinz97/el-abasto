@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-3">
            <div class="col-md-4">
                <h5>Listado de proveedores</h5>
            </div>
            <div class="col-md-8">
                <a href="{{route('proveedores.new')}}" class="btn btn-success float-right">Nuevo +</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 table-responsive">
                <table id="proveedores-table" class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Desc. Iva</th>
                            <th>Flete</th>
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
            $('#proveedores-table').DataTable({
                "serverside": true,
                "ajax": "{{route('datatables.proveedores')}}",
                "columns": [
                    {
                        data: 'id',
                        render: function (data, type, row){
                            return '#'+data.padStart(6, '0')
                        }
                    },
                    {data: 'name'},
                    {
                        data: 'email',
                        defaultContent: '-'
                    },
                    {
                        data: 'phone',
                        defaultContent: '-'
                    },
					{
                        data: 'discount_percent',
                        defaultContent: '-',
						render: function (data, type, row){
                            return Number(data).toFixed(2)+'%'
                        }
                    },
					{
                        data: 'shipping',
                        defaultContent: '-',
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

                    const url = route('proveedores.delete', id)

                    try{
                        const response = await axios.delete(url)

                        Swal.fire(
                            'Eliminado!',
                            'El proveedor fue eliminado',
                            'success'
                        )

                        $('#proveedores-table').DataTable().ajax.reload()
                        
                    }catch{
                        console.error(error)
                    }
                    
                }
            })
  
        }
    </script>
@endsection
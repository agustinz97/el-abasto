@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-3">
            <div class="col-md-4">
                <h5>Listado de marcas</h5>
            </div>
            <div class="col-md-8">
                <a href="{{route('marcas.new')}}" class="btn btn-success float-right">Nuevo +</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 table-responsive">
                <table id="marcas-table" class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th width="10%">#</th>
                            <th>Nombre</th>
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
            $('#marcas-table').DataTable({
                "serverside": true,
                "ajax": "{{route('datatables.marcas')}}",
                "columns": [
                    {data: 'id'},
                    {data: 'name'},
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

                    const url = route('marcas.delete', id)

                    try{
                        const response = await axios.delete(url)

                        Swal.fire(
                            '¡Eliminado!',
                            'La marca fue eliminada',
                            'success'
                        )

                        $('#marcas-table').DataTable().ajax.reload()
                        
                    }catch{
                        Swal.fire(
                            '¡Algo salió mal!',
                            'Intente de nuevo mas tarde.',
                            'error'
                        )

                        console.error(error)
                    }
                    
                }
            })
  
        }
    </script>
@endsection
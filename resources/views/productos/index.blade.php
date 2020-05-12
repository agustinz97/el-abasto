@extends('layouts.app')

@section('styles')
<style>
	tfoot {
		display: table-header-group;
	}
</style>
@endsection

@section('content')
    <div class="container">
        <div class="row mb-3">
            <div class="col-md-4">
                <h5>Listado de productos</h5>
			</div>
			<div class="col-md-8 col-sm-12">
				<a href="{{route('productos.new')}}" class="btn btn-primary float-right">
					Nuevo +
				</a>
			</div>
        </div>
        <div class="row">
            <div class="col-md-12 table-responsive">
                <table id="productos-table" class="table table-hover table-striped nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th width="10%">Proveedor</th>
                            <th width="10%">Marca</th>
							<th width="20%">Nombre</th>
                            <th>Precio de lista</th>
                            <th>Descuento IVA</th>
                            <th>Flete</th>
							<th>Precio real</th>
							<th>&nbsp;</th>
                        </tr>
					</thead>
					<tfoot>
						<caption>Todos los precios son unitarios</caption>
					</tfoot>
                </table>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Actualizar precio</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('productos.updatePrices')}}" method="POST" id="updatePricesForm">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6 col-md-8 col-sm-12">
                            <label for="percentage">Porcentaje de incremento</label>
                            <div class="input-group mb-3">
                                
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    name="percentage" id="percentage"
                                    placeholder ="0">
                                <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary float-right">Actualizar</button>
                    <button type="button" class="btn btn-secondary float-right mr-2" data-dismiss="modal">Cancelar</button>
                </form>
            </div>
            <div class="modal-footer">
                <h6>Se incrementará el precio de todos los productos elegidos</h6>
            </div>
        </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

			$('#productos-table tfoot th').each( function () {
				var title = $(this).text();
				$(this).html( '<input type="text" class="form-control form-control-sm" placeholder="Buscar por '+title+'" />' );
			} );

            let table = $('#productos-table').DataTable({
                "order": [[ 3, "asc" ]],
                "serverside": true,
                "ajax": "{{route('datatables.productos')}}",
                "columns": [
                    {data: 'proveedor.name'},
                    {data: 'marca.name'},
                    {data: 'format_name'},
                    {
						data: 'price',
						render: function (data, type, row){
                            return '$'+Number(data).toFixed(2)
                        }
					},
                    {
						data: 'proveedor.discount_percent',
						render: function (data, type, row){
                            return '$'+Number(data).toFixed(2)
                        }
					},
                    {
						data: 'proveedor.shipping',
						render: function (data, type, row){
                            return '$'+Number(data).toFixed(2)
                        }
					},
                    {
						data: 'base_price',
						render: function (data, type, row){
                            return '$'+Number(data).toFixed(2)
                        }
					},
					{
						data: 'btn'
					}
                ] ,
				/* initComplete: function () {
					this.api().columns().every(function () {
						var column = this;
						var input = document.createElement("input");
						$(input).appendTo($(column.footer()).empty())
						.on('keyup', function () {
							column.search($(this).val(), false, false, true).draw();
						});
					});
				} */
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
                        
                    }catch(error){
                        console.error(error.response.data)
                    }
                    
                }
            })
  
        }
    </script>
    <script>
        const form = document.querySelector('#updatePricesForm');
        const table =  document.querySelector('#productos-table')
        form.onsubmit = async function (e){
            e.preventDefault();

            let ids = [];    
            Array.from(table.rows).forEach((row, i) => {
                
                if(i>0){
                    const value = row.cells[0].textContent;
                    ids.push(parseInt(value.substring(1)))
                }

            });

            const postData = {
                productos: ids,
                percentage: form['percentage'].value,
            }
            
            try{
                const res = await axios.post(route('productos.updatePrices'), postData)

                Swal.fire(
                    '¡Correcto!',
                    'Los precios fueron actualizados',
                    'success'
                )
                $('#productos-table').DataTable().ajax.reload()
                $('#exampleModal').modal('hide');

            }catch(error){

                Swal.fire(
                    '¡Ups! Algo salió mal',
                    'Intente de nuevo mas tarde',
                    'error'
                )
                console.error(error)
            }
            
        }
    </script>
@endsection
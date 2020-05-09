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
            <div class="col-md-4 col-sm-12">
                <h5>Lista de precios al <small>{{Carbon\Carbon::now()->format('d/m/Y')}}</small></h5>
			</div>
			<div class="col-md-8 col-sm-12">
				<a target="_blank"
					href="{{route('print.publicPrices')}}" 
					class="btn btn-info float-right text-white">
					Imprimir
				</a>
			</div>
        </div>
        <div class="row">
            <div class="col-md-12 table-responsive">
                <table id="productos-table" class="table table-hover table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th width="20%">Marca</th>
							<th width="30%">Nombre</th>
                            <th>Precio Kg</th>
                            <th>Precio minorista</th>
                            <th>Precio reventa</th>
                            <th>Precio mayorista</th>
                        </tr>
					</thead>
					<tfoot>
						<tr>
							<th>Marca</th>
							<th>Nombre</th>
						</tr>
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
                "order": [[ 2, "asc" ]],
                "serverside": true,
                "ajax": "{{route('datatables.productos')}}",
                "columns": [
                    {data: 'marca'},
                    {data: 'format_name'},
                    {
                        data: 'kg_price',
                        render: function (data, type, row){
                            if(data > 0){
								return '$'+Number(data).toFixed(2)
							}else{
								return '-'
							}
                        },
						searchable: false,
                    },
                    {
                        data: 'retail_price',
                        render: function (data, type, row){
                            return '$'+Number(data).toFixed(2)
                        },
						searchable: false,
                    },
                    {
                        data: 'resale_price',
                        render: function (data, type, row){
                            return '$'+Number(data).toFixed(2)
                        },
						searchable: false,
                    },
                    {
                        data: 'wholesale_price',
                        render: function (data, type, row){
                            return '$'+Number(data).toFixed(2)
                        },
						searchable: false,
                    },
                ] ,
				initComplete: function () {
					this.api().columns().every(function () {
						var column = this;
						var input = document.createElement("input");
						input.placeholder = 'Buscar por '+title
						$(input).appendTo($(column.footer()).empty())
						.on('keyup', function () {
							column.search($(this).val(), false, false, true).draw();
						});
					});
				}
            });
        } );
    </script>
@endsection
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
                <table id="productos-table" class="table table-hover table-striped" style="width:100%">
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
	<!-- Modal Show Producto-->
    <div class="modal fade" id="modalShowProducto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" >Actualizar producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" id="updateProducto" class="container-fluid">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-lg-6 col-md-8 col-sm-12">
                            <label for="proveedor">Proveedor</label>
                            <select class="custom-select" id="proveedor" name="proveedor" disabled>
								@foreach($proveedores as $proveedor)
								<option value="{{$proveedor->id}}">
									{{$proveedor->name}}
								</option>
								@endforeach
							</select>
						</div>
						<div class="col-lg-6 col-md-8 col-sm-12">
                            <label for="marca">Marca</label>
                            <select class="custom-select" id="marca" name="marca" disabled>
								@foreach($marcas as $marca)
								<option value="{{$marca->id}}">
									{{$marca->name}}
								</option>
								@endforeach
							</select>
                        </div>
					</div>
					<div class="row mb-3">
                        <div class="col-lg-8 col-md-8 col-sm-12">
                            <label for="name">Nombre</label>
                            <div class="input-group mb-3">
                                <input 
                                    type="text" 
                                    class="form-control" 
									name="name" id="name"
									disabled>
                            </div>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-12">
                            <label for="kg">Kg</label>
                            <div class="input-group mb-3">
                                <input 
                                    type="number" step="0.01" 
                                    class="form-control" 
									name="kg" id="kg"
									disabled>
                                <div class="input-group-append">
                                    <span class="input-group-text">Kg</span>
                                </div>
                            </div>
						</div>
						
						<div class="col-lg-4 col-md-4 col-sm-12">
                            <label for="price">Precio</label>
                            <div class="input-group mb-3">
								<div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input 
                                    type="number" step="0.01" 
                                    class="form-control" 
									name="price" id="price"
									disabled>
                            </div>
						</div>
						
						<div class="col-lg-4 col-md-4 col-sm-12">
                            <label for="unit">Unidades</label>
                            <div class="input-group mb-3">
                                <input 
                                    type="number" step="0.01" 
                                    class="form-control" 
									name="unit" id="unit"
									disabled>
                            </div>
                        </div>
					</div>
					
                    <div class="row">
						<div class="col">
							<button type="button" id="btnCancel" class="btn btn-secondary float-right" hidden>Cancelar</button>
                    		<button type="button" id="btnEdit" class="btn btn-primary float-right mr-2">Editar</button>
                    		<button type="button" id="btnSave" class="btn btn-success float-right mr-2" hidden>Guardar</button>
						</div>
					</div>
                </form>
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

		function setInputs(producto){
			document.getElementById('marca').value = producto.marca.id
			document.getElementById('proveedor').value = producto.proveedor.id
			document.getElementById('name').value = producto.name
			document.getElementById('price').value = producto.price
			document.getElementById('kg').value = producto.kg
			document.getElementById('unit').value = producto.units
		}

		document.getElementById('btnCancel')
			.addEventListener('click', function(){
				setInputs(window.producto)
				document.getElementById('updateProducto')
					.querySelectorAll('input:not([type="hidden"]), select')
					.forEach(input => {
						input.disabled = true
					})
				this.hidden = true
				document.getElementById('btnSave').hidden = true
				document.getElementById('btnEdit').hidden = false
			})

		document.getElementById('btnEdit')
			.addEventListener('click', function(){
				document.getElementById('updateProducto')
					.querySelectorAll('input:not([type="hidden"]), select')
					.forEach(input => {
						input.disabled = false
					})
				this.hidden = true
				document.getElementById('btnSave').hidden = false
				document.getElementById('btnCancel').hidden = false
			})

		document.getElementById('btnSave')
			.addEventListener('click', function(){

				const formProducto = document.getElementById('updateProducto')
				const url = route('productos.update', window.producto.id)
				const data = {
					proveedor: formProducto['proveedor'].value,
					marca: formProducto['marca'].value,
					nombre: formProducto['name'].value,
					unidades: formProducto['unit'].value,
					kg: formProducto['kg'].value,
					precio: formProducto['price'].value,
				}

				axios.post(url, data)
					.then(res => {
						Swal.fire({
							title: 'Actualización exitosa',
							icon: 'success',
							showConfirmButton: false,
							timer: 1000
						})
						document.getElementById('updateProducto')
							.querySelectorAll('input:not([type="hidden"]), select')
							.forEach(input => {
								input.disabled = true
							})

						document.getElementById('btnSave').hidden = true
						document.getElementById('btnCancel').hidden = true
						document.getElementById('btnEdit').hidden = false

                        $('#productos-table').DataTable().ajax.reload()
					})
					.catch(err => {
						Swal.fire(
							'Error',
							err.response || err.message,
							'error'
						)
					})

				
				/* .then(()=>{
					$('#modalShowProducto').modal('hide')
				}) */
			})

		function show(id){

			axios.get(route('productos.show', id))
				.then(res => {
					window.producto = res.data
					
					setInputs(window.producto)
				})
				.then(()=>{
					$('#modalShowProducto').modal('show')
				})
				.catch(err => {
					Swal.fire(
						'Error',
						err.response?.data || err.message,
						'error'
					)
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
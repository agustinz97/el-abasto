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
	
	<!-- Modal Show Proveedor-->
    <div class="modal fade" id="modalShowProveedor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" >Actualizar proveedor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" id="updateProveedor" class="container-fluid">
					<div class="alert alert-danger" style="display: none" id="errorsBadge"> </div>
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
					</div>
					<div class="row mb-3">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label for="email">Correo electrónico</label>
                            <div class="input-group mb-3">
                                <input 
                                    type="text" 
                                    class="form-control" 
									name="email" id="email"
									disabled>
                            </div>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-12">
                            <label for="telefono">Teléfono</label>
                            <div class="input-group mb-3">
                                <input 
                                    type="text" 
                                    class="form-control" 
									name="telefono" id="telefono"
									disabled>
                            </div>
						</div>						
					</div>
					
					<div class="row mb-3">
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <label for="descuento">Descuento IVA</label>
                            <div class="input-group mb-3">
                                <input 
                                    type="number" step="0.1" 
                                    class="form-control" 
									name="descuento" id="descuento"
									disabled>
								<div class="input-group-append">
									<span class="input-group-text">%</span>
								</div>
                            </div>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-12">
                            <label for="flete">Flete</label>
                            <div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text">$</span>
								</div>
                                <input 
                                    type="number" step="0.1" 
                                    class="form-control" 
									name="flete" id="flete"
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

		document.querySelector('#updateProveedor')
			.addEventListener('submit', evt => {
				evt.preventDefault()
			})
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
	<script>
		function setInputs(proveedor){
			document.getElementById('name').value = proveedor.name
			document.getElementById('email').value = proveedor.email
			document.getElementById('telefono').value = proveedor.phone
			document.getElementById('descuento').value = proveedor.discount_percent
			document.getElementById('flete').value = proveedor.shipping
		}

		document.getElementById('btnCancel')
			.addEventListener('click', function(){
				setInputs(window.proveedor)
				document.getElementById('updateProveedor')
					.querySelectorAll('input:not([type="hidden"]), select')
					.forEach(input => {
						input.disabled = true
					})
				this.hidden = true
				document.getElementById('btnSave').hidden = true
				document.getElementById('btnEdit').hidden = false
				const errorsBadge = document.querySelector('#errorsBadge').style.display = 'none'
			})

		document.getElementById('btnEdit')
			.addEventListener('click', function(){
				document.getElementById('updateProveedor')
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
				const errorsBadge = document.querySelector('#errorsBadge')
				const formProducto = document.getElementById('updateProveedor')
				const url = route('proveedores.update', window.proveedor.id)
				const data = {
					nombre: formProducto['name'].value,
					email: formProducto['email'].value,
					telefono: formProducto['telefono'].value,
					descuento: formProducto['descuento'].value,
					flete: formProducto['flete'].value,
				}

				axios.post(url, data)
					.then(res => {
						Swal.fire({
							title: 'Actualización exitosa',
							icon: 'success',
							showConfirmButton: false,
							timer: 1000
						})
						document.getElementById('updateProveedor')
							.querySelectorAll('input:not([type="hidden"]), select')
							.forEach(input => {
								input.disabled = true
							})

						document.getElementById('btnSave').hidden = true
						document.getElementById('btnCancel').hidden = true
						document.getElementById('btnEdit').hidden = false

                        $('#proveedores-table').DataTable().ajax.reload()
						errorsBadge.style.display = 'none'
					})
					.catch(err => {
						
						if(err.response.status === 422){
							const errors = Object.values(err.response.data)

							errorsBadge.innerHTML = '';

							const ul = document.createElement('ul')
							ul.classList.add('mb-0')
							
							errors.forEach(error => {
								const li = document.createElement('li')
								li.textContent = error

								ul.appendChild(li)
							})

							errorsBadge.appendChild(ul)
							errorsBadge.style.display = 'block'
						}else{
							Swal.fire(
								'Error',
								err.response.data || err.message,
								'error'
							)
						}
						
					})

			})

		function show(id){

			axios.get(route('proveedores.show', id))
				.then(res => {
					window.proveedor = res.data
					
					setInputs(window.proveedor)
				})
				.then(()=>{
					$('#modalShowProveedor').modal('show')
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
@endsection
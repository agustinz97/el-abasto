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
	<!-- Modal Show Proveedor-->
    <div class="modal fade" id="modalShowMarca" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" >Actualizar proveedor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" id="updateMarca" class="container-fluid">
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

		document.querySelector('#updateMarca')
			.addEventListener('submit', evt => {
				evt.preventDefault()
			})

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

		function setInputs(marca){
			document.getElementById('name').value = marca.name
		}

		document.getElementById('btnCancel')
			.addEventListener('click', function(){
				setInputs(window.marca)
				document.getElementById('updateMarca')
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
				document.getElementById('updateMarca')
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
				const formProducto = document.getElementById('updateMarca')
				const url = route('marcas.update', window.marca.id)
				const data = {
					nombre: formProducto['name'].value,
				}

				axios.post(url, data)
					.then(res => {
						Swal.fire({
							title: 'Actualización exitosa',
							icon: 'success',
							showConfirmButton: false,
							timer: 1000
						})
						document.getElementById('updateMarca')
							.querySelectorAll('input:not([type="hidden"]), select')
							.forEach(input => {
								input.disabled = true
							})

						document.getElementById('btnSave').hidden = true
						document.getElementById('btnCancel').hidden = true
						document.getElementById('btnEdit').hidden = false

                        $('#marcas-table').DataTable().ajax.reload()
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
								err.message,
								'error'
							)
						}
						
					})

			})
		
		function show(id){

			axios.get(route('marcas.show', id))
				.then(res => {
					window.marca = res.data
					
					setInputs(window.marca)
				})
				.then(()=>{
					$('#modalShowMarca').modal('show')
				})
				.catch(err => {
					Swal.fire(
						'Error',
						err.message,
						'error'
					)
				})
			
		}
    </script>
@endsection
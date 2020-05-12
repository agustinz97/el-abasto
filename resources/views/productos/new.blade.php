@extends('layouts.app')

@section('content')
    <div class="container">
		<div class="row mb-3">
			<div class="col">
				<a href="{{route('productos.index')}}" class="btn btn-primary float-right">
					Volver al listado
				</a>
			</div>
		</div>
        <div class="row">
            <div class="col-lg-8 col-md-10 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        Nuevo producto
                    </div>
                    <div class="card-body">
						<div class="alert alert-danger" style="display: none" id="errors-producto">
						</div>
                        <form action="{{route('productos.create')}}" method="POST" id="newProducto-form">
							@csrf
							
							<div class="row">
								<div class="col-md-6 col-sm-12">
                                    <label for="marca">Proveedor</label>
                                    <div class="input-group mb-3">
										<select class="custom-select" required id="proveedor" name="proveedor">
											<option value="">Seleccione el proveedor</option>
											@foreach($proveedores as $proveedor)
											<option value="{{$proveedor->id}}" {{old('proveedor') == $proveedor->id ? 'selected' : ''}}>
												{{$proveedor->name}}
											</option>
											@endforeach
										</select>
										<button 
											class="btn btn-primary ml-2" 
											data-toggle="modal" data-target="#modal-proveedor"
											id="btnProveedor"
											type="button"
											tabindex="-1">
											Nuevo +
										</button>
									</div>
								</div>

								<div class="col-md-6 col-sm-12">
                                    <label for="marca">Marca</label>
                                    <div class="input-group mb-3">
										<select class="custom-select" id="marca" name="marca">
											<option value="">Seleccione la marca</option>
											@foreach($marcas as $marca)
											<option value="{{$marca->id}}" {{old('marca') == $marca->id ? 'selected' : ''}}>
												{{$marca->name}}
											</option>
											@endforeach
										</select>
										<button 
											class="btn btn-primary ml-2" 
											data-toggle="modal" data-target="#modal-marca"
											id="btnMarca"
											type="button"
											tabindex="-1">
											Nueva +
										</button>
									</div>
								</div>
							</div>

                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <label for="name">Nombre del producto</label>
                                    <div class="input-group mb-3">
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            id="name" name="name"
											required>
                                    </div>
								</div>
								<div class="col-md-3 col-sm-12">
                                    <label for="kg">Kg</label>
                                    <div class="input-group mb-3">
                                        <input 
                                            type="number" step="0.001"
                                            class="form-control" 
                                            id="kg" name="kg"
                                            placeholder="0">
                                    </div>
								</div>
							</div>

							<div class="row">
								
								<div class="col-md-3 col-sm-12">
                                    <label for="units">Unidades</label>
                                    <div class="input-group mb-3">
                                        <input 
                                            type="number" step="1"
                                            class="form-control" 
											id="units" name="units"
											placeholder="1"
                                            >
                                    </div>
								</div>
								<div class="col-md-3 col-sm-12">
                                    <label for="price">Precio de compra</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">$</span>
                                        </div>
                                        <input 
                                            type="number" step="0.1"
                                            class="form-control" 
                                            id="price" name="price"
											required
											>
                                    </div>
                                </div>
							</div>

                            {{-- <div class="row">

                                <div class="col-md-4 col-sm-12">
                                    <label for="stock">Stock incial</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-preppend">
                                            <span class="input-group-text">Stock</span>
                                        </div>
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            name="stock" id="stock"
                                            value="{{old('stock')}}">
                                      </div>
                                </div>
                            </div> --}}
							
                            <div class="form-group">
                                <button class="btn btn-success float-right">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
	</div>
	
	<!-- Modal Nueva Marca -->
    <div class="modal fade" id="modal-marca" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Crear marca</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @include('partials.new-marca-form')
            </div>
        </div>
        </div>
	</div>
	
	<!-- Modal Nuevo Proveedor -->
    <div class="modal fade" id="modal-proveedor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Crear proveedor</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					@include('partials.new-proveedor-form')
				</div>
			</div>
        </div>
    </div>
@endsection

@section('scripts')
	<script>

		$('#modal-marca').on('shown.bs.modal', function () {
			$('#name-marca').focus();
		})

		$('#modal-proveedor').on('shown.bs.modal', function () {
			$('#name-proveedor').focus();
		})
	</script>

	<script>
		const formProducto = document.querySelector('#newProducto-form')
		const errorsProducto = document.querySelector('#errors-producto')

		formProducto.addEventListener('submit', async function(evt){
			evt.preventDefault()
			
			const url = route('productos.create')
			const data = {
				proveedor: formProducto['proveedor'].value,
				marca: formProducto['marca'].value,
				nombre: formProducto['name'].value,
				unidades: formProducto['units'].value,
				kg: formProducto['kg'].value,
				precio: formProducto['price'].value,
			}

			try{
				
				const res = await axios.post(url, data);

				Swal.fire({
					title: 'Producto agregado',
					icon: 'success',
					showConfirmButton: false,
					timer: 1000
				})

				this.reset()
				errorsProducto.innerHTML = ''
				errorsProducto.style.display = 'none'
				this['proveedor'].value = data.proveedor
				this['marca'].value = data.marca
			}catch(error){
				if(error.response.status === 500){
					Swal.fire({
						title: 'Algo salió mal.',
						text: error.response.data,
						icon: 'error',
					})

				}else if(error.response.status === 422){

					const errors = Object.values(error.response.data)

					errorsProducto.innerHTML = '';

					const ul = document.createElement('ul')
					ul.classList.add('mb-0')
					
					errors.forEach(error => {
						const li = document.createElement('li')
						li.textContent = error

						ul.appendChild(li)
					})

					errorsProducto.appendChild(ul)
					errorsProducto.style.display = 'block'
					console.log('hola mundo')
				}
			}

		})
	</script>
@endsection
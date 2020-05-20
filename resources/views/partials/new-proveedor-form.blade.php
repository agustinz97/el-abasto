<div class="alert alert-danger" style="display: none" id="errors-proveedor">
</div>
<form action="#" id="newProveedor-form" method="POST">
	@csrf
	<div class="row">
		<div class="col">
			<div class="form-group">
				<label for="name">Nombre del proveedor</label>
				<div class="input-group mb-3">
					<input 
						type="text" 
						class="form-control" 
						id="name-proveedor" name="name"
						value="{{old('name')}}"
						required>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-7 col-md-12 col-sm-12">
			<div class="form-group">
				<label for="email">Correo electrónico</label>
				<div class="input-group mb-3">
					<input 
						type="email" 
						class="form-control" 
						id="email" name="email"
						value="{{old('email')}}"
						>
				</div>
			</div>
		</div>
		<div class="col-lg-5 col-md-12 col-sm-12">
			<div class="form-group">
				<label for="phone">Teléfono</label>
				<div class="input-group mb-3">
					<input 
						type="text" 
						class="form-control" 
						id="phone" name="phone"
						value="{{old('phone')}}"
						>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-lg-4 col-md-12">
			<div class="form-group">
				<label for="discount">Descuento IVA</label>
				<div class="input-group mb-3">

					<input 
						type="number" step="0.1"
						class="form-control" 
						id="discount" name="discount"
						placeholder="0">
					<div class="input-group-append">
						<span class="input-group-text">%</span>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-4 col-md-12">
			<div class="form-group">
				<label for="shipping">Flete</label>
				<div class="input-group mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text">$</span>
					</div>
					<input 
						type="number" step="0.1"
						class="form-control" 
						id="shipping" name="shipping"
						placeholder="0">
				</div>
			</div>
		</div>
	</div>

	<div class="form-group">
		<button class="btn btn-success float-right">Guardar</button>
	</div>
</form>
<script>

	const formProveedor = document.querySelector('#newProveedor-form')
	const errorsProveedor = document.querySelector('#errors-proveedor')

	formProveedor.addEventListener('submit', async function (evt) {
		evt.preventDefault()

		const url = route('proveedores.create')
		const data = {
			nombre: this['name'].value,
			email: this['email'].value,
			telefono: this['phone'].value,
			flete: this['shipping'].value,
			descuento: this['discount'].value
		}

		try{
			const res = await axios.post(url, data)
		
			Swal.fire({
				title: 'Proveedor agregado',
				icon: 'success',
				showConfirmButton: false,
				timer: 1000
			})

			this.reset()
			errorsProveedor.innerHTML = ''
			errorsProveedor.style.display = 'none'

			const selectProveedores = document.querySelector('#proveedor')
			selectProveedores.options.add(new Option(res.data.name, res.data.id))
		}catch(error){

			if(error.response.status === 500){
				Swal.fire({
					title: 'Algo salió mal.',
					text: 'Intente de nuevo mas tarde.',
					icon: 'error',
				})
			}else if(error.response.status === 422){

				const errors = Object.values(error.response.data)

				errorsProveedor.innerHTML = '';

				const ul = document.createElement('ul')
				ul.classList.add('mb-0')
				
				errors.forEach(error => {
					const li = document.createElement('li')
					li.textContent = error

					ul.appendChild(li)
				})

				errorsProveedor.appendChild(ul)
				errorsProveedor.style.display = 'block'

			}

		}
	})

</script>
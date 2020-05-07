<form action="#" id="newProveedor-form" method="POST">
	@csrf
	<div class="form-group">
		<label for="name">Nombre del proveedor</label>
		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<span class="input-group-text">Nombre</span>
			</div>
			<input 
				type="text" 
				class="form-control" 
				id="name-proveedor" name="name"
				value="{{old('name')}}"
				required>
		</div>
	</div>
	<div class="form-group">
		<label for="email">Correo electrónico</label>
		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<span class="input-group-text">Correo electrónico</span>
			</div>
			<input 
				type="email" 
				class="form-control" 
				id="email" name="email"
				value="{{old('email')}}"
				>
		</div>
	</div>
	<div class="form-group">
		<label for="phone">Teléfono</label>
		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<span class="input-group-text">Teléfono</span>
			</div>
			<input 
				type="text" 
				class="form-control" 
				id="phone" name="phone"
				value="{{old('phone')}}"
				>
		</div>
	</div>

	<div class="form-group">
		<button class="btn btn-success float-right">Guardar</button>
	</div>
</form>
<script>

	const form = document.querySelector('#newProveedor-form')

	form.addEventListener('submit', async function (evt) {
		evt.preventDefault()

		const url = route('proveedores.create')
		const data = {
			nombre: this['name'].value,
			email: this['email'].value,
			telefono: this['phone'].value,
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
		}catch(error){

			if(error.response.status === 500){
				Swal.fire({
					title: 'Algo salió mal.',
					text: 'Intente de nuevo mas tarde.',
					icon: 'error',
				})
			}else if(error.response.status === 422){

				const errors = Object.values(error.response.data)
				const errorsBag = document.querySelector('#errors')

				errorsBag.innerHTML = '';

				const ul = document.createElement('ul')
				ul.classList.add('mb-0')
				
				errors.forEach(error => {
					const li = document.createElement('li')
					li.textContent = error

					ul.appendChild(li)
				})

				errorsBag.appendChild(ul)
				errorsBag.style.display = 'block'

			}

		}
	})

</script>
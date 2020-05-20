<div class="alert alert-danger" style="display: none" id="errors-marca">
</div>
<form action="#" method="POST" id="newMarca-form">
	@csrf
	<div class="form-group">
		<label for="name">Nombre de la marca</label>
		<div class="input-group mb-3">
			<input 
				type="text" 
				class="form-control" 
				id="name-marca" name="name">
		</div>
	</div>
	
	<div class="form-group">
		<button class="btn btn-success float-right">Guardar</button>
	</div>
</form>

<script>

	const formMarca = document.querySelector('#newMarca-form')
	const errorsBag = document.querySelector('#errors-marca')

	formMarca.addEventListener('submit', async function (evt) {
		evt.preventDefault()

		const url = route('marcas.create')
		const data = {
			nombre: this['name'].value,
		}

		try{
			const res = await axios.post(url, data)
		
			Swal.fire({
				title: 'Marca agregada',
				icon: 'success',
				showConfirmButton: false,
				timer: 1000
			})

			errorsBag.style.display = 'none'
			errorsBag.innerHTML = ''
			this.reset()

			const selectMarcas = document.querySelector('#marca')
			selectMarcas.options.add(new Option(res.data.name, res.data.id))
		}catch(error){
			console.log(error.response.data)

			if(error.response.status === 500){
				Swal.fire({
					title: 'Algo salió mal.',
					text: 'Intente de nuevo mas tarde.',
					icon: 'error',
				})
			}else if(error.response.status === 422){

				const errors = Object.values(error.response.data)

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
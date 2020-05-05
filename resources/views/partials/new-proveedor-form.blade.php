<form action="{{route('proveedores.create')}}" id="create-form" method="POST">
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
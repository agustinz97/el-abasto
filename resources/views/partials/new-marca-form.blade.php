<form action="{{route('marcas.create')}}" method="POST">
	@csrf
	<div class="form-group">
		<label for="name">Nombre de la marca</label>
		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<span class="input-group-text">Nombre</span>
			</div>
			<input 
				type="text" 
				class="form-control" 
				id="name-marca" name="name"
				value="{{old('name')}}"
				required>
		</div>
	</div>
	
	<div class="form-group">
		<button class="btn btn-success float-right">Guardar</button>
	</div>
</form>
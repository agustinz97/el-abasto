@extends('layouts.app')

@section('styles')
	<style>
		.loading {
			padding: 30px;
			border-radius: 10px;
			background-color: #f2f2f2;
			box-shadow: 4px 7px 24px -1px rgba(0,0,0, .6);
			display: flex;
			flex-direction: column;
			justify-content: center;
			align-items:center;

			position: fixed;
			top: 50%;
			left: 50%;
			transform: translate(-50%, -50%);

			transition: opacity ease .2s;
		}

		.loading.hide{
			opacity: 0;
		}

		.loading > div{
			display: flex;
			flex-direction: row;
		}

		.loading .circle{
			width: 1rem;
			height: 1rem;
			margin: 2rem 0.3rem;
			background: #979fd0;
			border-radius: 50%;
			animation: 0.9s bounce infinite alternate;
		}

		.loading .circle:nth-child(2){
			animation-delay: 0.3s;
		}

		.loading .circle:nth-child(3) {
			animation-delay: 0.6s;
		}

		@keyframes bounce {
			to {
				opacity: 0.3;
				transform: translate3d(0, -1rem, 0);
			}
		}
	</style>
@endsection

@section('content')
    <div class="container">
		<div class="row mb-5">
			<div class="col-6">
				<h3>Lista de Precios</h3>
			</div>
			<div class="col-6">
				<p class="float-right my-auto">
					<span class="material-icons" style="vertical-align: middle;">
						today
					</span>
					{{Carbon\Carbon::now()->format('d/m/Y')}}
				</p>
			</div>
		</div>
        <div class="row ">
            <div class="col-md-3 col-sm-12 mb-3">
				<div class="input-group">
					<select class="custom-select" required id="selectMarcas" name="marca">
						<option value="">Todas las marcas</option>
					</select>
				</div>
			</div>
			<div class="col-md-9 col-sm-12 mb-3">
				<a target="_blank" id="btnPrint"
					{{-- href="{{route('print.publicPrices')}}" --}}
					class="btn btn-info float-right text-white">
					<span class="material-icons" style="vertical-align: middle;">
						print
					</span>
				</a>
			</div>
        </div>
        <div class="row">
            <div class="col-md-12 table-responsive">
                <table id="productos-table" class="table table-hover table-striped" style="width:100%">
                    <thead>
                        <tr class="text-center">
							<th width="40%">Descripción</th>
                            <th>Precio Kg</th>
                            <th>Precio minorista</th>
                            <th>Precio reventa</th>
                            <th>Precio mayorista</th>
                        </tr>
					</thead>
					<tbody class="text-right">

					</tbody>
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
	
	<!-- Loader -->
    <div class="loading hide" id="loader">
		<h2>Cargando</h2>
		<div>
			<div class="circle"></div>
			<div class="circle"></div>
			<div class="circle"></div>
		</div>
	</div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

			function fillDataTable(marca=null){
				$('#productos-table').DataTable({
					"order": [[ 0, "asc" ]],
					"serverside": true,
					"ajax": {
						url: "{{route('datatables.productos')}}",
						type: 'POST',
						data: {
							marca: marca
						}
					},
					"columns": [
						{
							data: 'format_name',
							render: function (data, type, row){
								const marca = row['marca'].name
								return `${marca} ${data}`
							},
							className: "text-left"
						},
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
					],
				});
			}

            fillDataTable()

			function print(){
				let ids = []
				$('#productos-table').DataTable().rows({search: 'applied'}).every(function(index){
					ids.push(this.row(index).data().id)
				})

				const url = route('print.publicPrices')
				const data = {
					ids,
				}
				
				document.querySelector('#loader').classList.remove('hide');

				axios.post(url, data)
					.then(res => {
						let stream = window.open(res.data, '_blank')
						stream.focus()
					})
					.catch(err => {
						Swal.fire({
							title: 'Algo salió mal',
							text: err || 'Intente de nuevo mas tarde',
							icon: 'error',
							showConfirmButton: false,
							timer: 1000
						})
					})
					.finally(() => {
						document.querySelector('#loader').classList.add('hide');
					})
			}
			
			const btnPrint = document.querySelector('#btnPrint')
			btnPrint.addEventListener('click', print)

			
			const select = document.getElementById('selectMarcas')
			function loadSelect(select, elements){

				elements.forEach(x => {
					select.options.add(new Option(x.name, x.id))
				})

			}

			function updateTable(){
				let marca = document.querySelector('#selectMarcas').value;
				console.log(marca)

				$('#productos-table').DataTable().destroy();
				fillDataTable(marca)
			}

			axios.get(route('marcas.all'))
				.then(res => {
					loadSelect(select, res.data)
				})
			
			select.addEventListener('change', updateTable)

        } );
		
	</script>
@endsection
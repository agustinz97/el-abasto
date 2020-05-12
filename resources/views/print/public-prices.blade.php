<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Lista de precios {{Carbon\Carbon::now()->format('d/m/Y')}}</title>
	
	<style type="text/css">
        @page {
            margin: 220px 25px 90px 25px;
        }
		* {
			font-family: Verdana, Geneva, Tahoma, sans-serif;
		}
        a {
            color: #fff;
            text-decoration: none;
        }
		header{
			position: fixed;
			top: -200px;
			left: 0px;
			right: 0px;
		}
        table {
            font-size: x-small;
        }
        tfoot tr td {
            font-weight: bold;
            font-size: x-small;
        }
        .invoice table {
			border-collapse: collapse;
        }
		.invoice table td, .invoice table th{
			border: 1px solid black;
			padding: 5px
		}
		.invoice table tr:first-child(){
			background-color: rgb(59, 56, 56);
			color: white;
		}
		.invoice table tr:nth-child(2n){
			background-color: #ccc;
		}
        .invoice h3 {
            margin-left: 15px;
        }
        .information {
            background-color: white;
            color: black;
			border-bottom: 1px solid black;
        }
        .information .logo {
            margin: 5px;
        }
        .information table {
            padding: 10px;
        }

		.page-break {
			page-break-after: always;
		}

		.title{
			font-size: 20px;
		}
		.fecha{
			font-size: 12px;
			font-weight: normal;
		}
		footer {
			position: fixed; 
			bottom: -80px; 
			left: 0px; 
			right: 0px;
			height: 50px; 
			text-align: right;
		}
 
		footer .pagenum:before {
			content: counter(page);
		}

    </style>

</head>

<body>
	<header>
		<div class="information">
			<table width="100%">
				<tr>
					<td align="left" style="width: 40%;">
						<h3 class="title">El Abasto Forrajeria</h3>
	<pre>
	Alvarado 122
	Orán, Salta
	<br /><br />
	3878 - 624041
	elabastoforrajeriaoran@gmail.com
	</pre>
					</td>
					<td align="right" style="width: 60%;">
		
						<h3 class="title">Lista de Precios</h3>
						<h3 class="fecha">
							<strong>Fecha:</strong>
							{{Carbon\Carbon::now()->format('d/m/Y')}}
						</h3>
						<h3 class="fecha">
							<strong>Listado de:</strong>
							{{ucfirst($filterBy)}}
						</h3>
					</td>
				</tr>
		
			</table>
		</div>
	</header>	
		
	<main>
		<div class="invoice">
			<table width="100%">
				<thead>
					<tr>
						<th width="45%">Descripción</th>
						<th>Precio Kg</th>
						<th>Precio minorista</th>
						<th>Precio reventa</th>
						<th>Precio mayorista</th>
					</tr>
				</thead>
				<tbody>
					
					@foreach ($products as $item)

						<tr>
							<td align="left">{{$item->marca->name ?? ''}} {{$item->format_name}}</td>
							<td align="right">${{number_format($item->kg_price, 2)}}</td>
							<td align="right">${{number_format($item->retail_price, 2)}}</td>
							<td align="right">${{number_format($item->resale_price, 2)}}</</td>
							<td align="right">${{number_format($item->wholesale_price, 2)}}</</td>
						</tr>
					@endforeach
					
				</tbody>

			</table>
		</div>
	</main>

	<script type="text/php">
		if (isset($pdf)) {
			$text = "Página {PAGE_NUM} de {PAGE_COUNT}";
			$size = 10;
			$font = $fontMetrics->getFont("Verdana");
			$width = $fontMetrics->get_text_width($text, $font, $size) / 2;
			$x = ($pdf->get_width() - $width);
			$y = $pdf->get_height() - 35;
			$pdf->page_text($x, $y, $text, $font, $size);
		}
	</script>
</body>
</html>
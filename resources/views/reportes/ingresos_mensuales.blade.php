<x-layout meta-title="Reporte mensual de recibos" meta-description="Reporte mensual de recibos">

	<div class="p-6">

	<div class="flex justify-between items-center mb-4">

	<h1 class="text-2xl font-bold">
	Reporte de Ingresos por Mes - {{$anio}}
	</h1>

	<button onclick="window.print()"
	class="bg-blue-600 text-white px-4 py-2 rounded">
	Imprimir
	</button>

	</div>

	<form method="GET" class="mb-4">

	<select name="anio"
	class="border rounded px-3 py-2"
	onchange="this.form.submit()">

	@for($i=$anioActual; $i>=($anioActual-5); $i--)

	<option value="{{$i}}" {{$anio==$i?'selected':''}}>
	{{$i}}
	</option>

	@endfor

	</select>

	</form>


	<div class="overflow-x-auto">

	<table class="min-w-full border border-gray-300 text-sm">

	<thead class="bg-gray-200">

	<tr>

	<th class="border px-2">Matricula</th>
	<th class="border px-2">Nombre</th>

	<th class="border px-2 font-bold">Total</th>

	<th class="border px-2">Ene</th>
	<th class="border px-2">Feb</th>
	<th class="border px-2">Mar</th>
	<th class="border px-2">Abr</th>
	<th class="border px-2">May</th>
	<th class="border px-2">Jun</th>
	<th class="border px-2">Jul</th>
	<th class="border px-2">Ago</th>
	<th class="border px-2">Sep</th>
	<th class="border px-2">Oct</th>
	<th class="border px-2">Nov</th>
	<th class="border px-2">Dic</th>

	

	</tr>

	</thead>

	<tbody>

	@foreach($datos as $d)

	<tr class="text-center">

	<td class="border px-2">{{$d->matricula}}</td>
	<td class="border px-2 text-left">{{$d->nombre}}</td>

	<td class="border font-bold">{{number_format($d->total)}}</td>

	<td class="border">{{$d->enero}}</td>
	<td class="border">{{$d->febrero}}</td>
	<td class="border">{{$d->marzo}}</td>
	<td class="border">{{$d->abril}}</td>
	<td class="border">{{$d->mayo}}</td>
	<td class="border">{{$d->junio}}</td>
	<td class="border">{{$d->julio}}</td>
	<td class="border">{{$d->agosto}}</td>
	<td class="border">{{$d->septiembre}}</td>
	<td class="border">{{$d->octubre}}</td>
	<td class="border">{{$d->noviembre}}</td>
	<td class="border">{{$d->diciembre}}</td>

	

	</tr>

	@endforeach


	<tfoot class="bg-gray-300 font-bold text-center">

	<tr>

	<td colspan="2" class="border px-2 text-right">
	TOTAL GENERAL
	</td>
	<td class="border">{{number_format($totales['total'])}}</td>
	<td class="border">{{number_format($totales['enero'])}}</td>
	<td class="border">{{number_format($totales['febrero'])}}</td>
	<td class="border">{{number_format($totales['marzo'])}}</td>
	<td class="border">{{number_format($totales['abril'])}}</td>
	<td class="border">{{number_format($totales['mayo'])}}</td>
	<td class="border">{{number_format($totales['junio'])}}</td>
	<td class="border">{{number_format($totales['julio'])}}</td>
	<td class="border">{{number_format($totales['agosto'])}}</td>
	<td class="border">{{number_format($totales['septiembre'])}}</td>
	<td class="border">{{number_format($totales['octubre'])}}</td>
	<td class="border">{{number_format($totales['noviembre'])}}</td>
	<td class="border">{{number_format($totales['diciembre'])}}</td>

	

	</tr>

	</tfoot>



	</tbody>

	</table>

	</div>

	</div>


	<style>

	@media print{

	button, select{
	display:none;
	}

	body{
	background:white;
	}

	}

	</style>

</x-layout>
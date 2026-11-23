<x-layout meta-title="Reporte mensual de recibos" meta-description="Reporte mensual de recibos">

	<div class="p-6">

	<div class="flex justify-between items-center mb-4 no-print">

	<h1 class="text-2xl font-bold">
	Reporte de Ingresos por Mes - {{$anio}}
	</h1>

	<button onclick="window.print()"
	class="bg-blue-600 text-white px-4 py-2 rounded">
	Imprimir
	</button>

	</div>

	<form method="GET" action="{{ route('reportes.ingresos_mensuales') }}" class="flex flex-wrap gap-4 items-end mb-4 no-print">
	    <div>
	        <label class="block text-sm font-bold mb-1">Año</label>
	        <select name="anio" class="border rounded px-3 py-2">
	            @for ($a = $anioActual; $a >= $anioActual - 5; $a--)
	                <option value="{{ $a }}" {{ $anio == $a ? 'selected' : '' }}>{{ $a }}</option>
	            @endfor
	        </select>
	    </div>

	    <div>
	        <label class="block text-sm font-bold mb-1">Ordenar por</label>
	        <select name="orden" class="border rounded px-3 py-2">
	            <option value="apellido" {{ $orden == 'apellido' ? 'selected' : '' }}>Apellido + Nombre</option>
	            <option value="nombre" {{ $orden == 'nombre' ? 'selected' : '' }}>Nombre + Apellido</option>
	            <option value="matricula" {{ $orden == 'matricula' ? 'selected' : '' }}>Matrícula</option>
	        </select>
	    </div>

	    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
	        Filtrar
	    </button>
	</form>

	<div class="mb-4 text-center">
	    @if($asociacion)
	        <h2 class="text-base font-bold">{{ $asociacion }}</h2>
	    @endif
	    <h3 class="text-base font-bold">
	        Reporte de Ingresos Mensuales - Año {{ $anio }}
	    </h3>
	    <p class="text-xs text-gray-600 mt-1">
	        Ordenado por: 
	        <strong>
	            @if($orden === 'matricula') Matrícula
	            @elseif($orden === 'nombre') Nombre + Apellido
	            @else Apellido + Nombre
	            @endif
	        </strong>
	    </p>
	</div>


	<div class="overflow-x-auto">

	<table class="min-w-full border border-gray-300 text-sm">

	<thead class="bg-gray-200">

	<tr>

	<th class="border px-2">#</th>
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

	<td class="border px-2 text-gray-600">{{ $loop->iteration }}</td>
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

	</tbody>

	<tfoot class="bg-gray-300 font-bold text-center">

	<tr>

	<td colspan="3" class="border px-2 text-right">
	TOTAL GENERAL ({{ $datos->count() }} asociados)
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

	</table>

	</div>

	</div>


	<style>

	@media print{

	.no-print, button, select{
	display:none !important;
	}

	body{
	background:white;
	}

	}

	</style>

</x-layout>
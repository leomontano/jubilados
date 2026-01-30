<x-layout meta-title="Recibo" meta-description="Recibo Description">


<div class="max-w-7xl mx-auto py-6">
    <h1 class="text-2xl font-bold mb-6">📋 Reporte de Asistencias {{ $anio }}</h1>

    {{-- Selector de año --}}
    <form method="GET" action="{{ route('asistencia') }}" class="mb-4 flex items-center space-x-4">
        <label for="anio" class="font-semibold">Seleccionar año:</label>
        <select name="anio" id="anio" class="border rounded px-3 py-1">
            @foreach($aniosDisponibles as $year)
                <option value="{{ $year }}" {{ $anio == $year ? 'selected' : '' }}>
                    {{ $year }}
                </option>
            @endforeach
        </select>
        <button type="submit" class="bg-blue-600 text-white px-4 py-1 rounded hover:bg-blue-700">
            Filtrar
        </button>
    </form>

    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full border border-gray-300 text-sm text-center">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border">Asociado</th>
                    @for ($m = 1; $m <= 12; $m++)
                        <th class="px-2 py-2 border">
                            {{ \Carbon\Carbon::create()->month($m)->format('M') }}
                        </th>
                    @endfor
                </tr>
            </thead>
            <tbody>
                @php
                    $totales = array_fill(1, 12, 0);
                @endphp

                @if($asociados->isEmpty())
                    <tr>
                        <td colspan="13" class="px-4 py-6 text-center text-gray-500 italic">
                            🚫 No hay asistencias registradas en {{ $anio }}.
                        </td>
                    </tr>
                @else
                    @foreach($asociados as $asociado)
                        <tr>
                            <td class="px-4 py-2 border text-left">{{ $asociado->matricula . " " . $asociado->nombre . " " . $asociado->apellido }}</td>
                            @for ($m = 1; $m <= 12; $m++)
                                @php
                                    $asistio = $asistenciaMatrix[$asociado->matricula][$m] ?? false;
                                    if ($asistio) $totales[$m]++;
                                @endphp
                                <td class="px-2 py-2 border">
                                    @if($asistio)
                                        ✅
                                    @else
                                        ❌
                                    @endif
                                </td>
                            @endfor
                        </tr>
                    @endforeach

                    {{-- Totales --}}
                    <tr class="bg-gray-200 font-bold">
                        <td class="px-4 py-2 border text-right">Total</td>
                        @for ($m = 1; $m <= 12; $m++)
                            <td class="px-2 py-2 border">{{ $totales[$m] }}</td>
                        @endfor
                    </tr>
                @endif
            </tbody>

        </table>
        <div class="flex justify-end mb-4">
            <a href="{{ route('asistencias.reporte', ['anio' => $anio]) }}" 
               target="_blank"
               class="px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 focus:outline-none">
                🖨️ Imprimir reporte
            </a>
        </div>
    </div>
</div>



</x-layout>

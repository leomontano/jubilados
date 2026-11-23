<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Asistencias {{ $anio }}</title>
    <script>
        window.onload = function() { window.print(); }
    </script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="p-6">
    <h2 class="text-base font-bold mb-1 text-center">
        {{ $asociacion }}
    </h2>
    <h2 class="text-base font-bold mb-1 text-center">
        Reporte de Asistencias - Año {{ $anio }}
    </h2>
    <p class="text-xs text-gray-600 mb-3 text-center">
        Ordenado por: 
        <strong>
            @if($orden === 'matricula') Matrícula
            @elseif($orden === 'nombre') Nombre + Apellido
            @else Apellido + Nombre
            @endif
        </strong>
    </p>

    <table class="w-full border border-gray-300 text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-2 py-2 border text-center">#</th>
                <th class="px-3 py-2 border text-center">Matrícula</th>
                <th class="px-4 py-2 border text-left">Asociado</th>
                @for ($m = 1; $m <= 12; $m++)
                    <th class="px-2 py-2 border text-center">
                        {{ \Carbon\Carbon::create()->month($m)->locale('es')->translatedFormat('M') }}
                    </th>
                @endfor
            </tr>
        </thead>
        <tbody>
            @php $totales = array_fill(1, 12, 0); @endphp

            @if($asociados->isEmpty())
                <tr>
                    <td colspan="15" class="px-4 py-6 text-center text-gray-500 italic">
                        🚫 No hay asistencias registradas en {{ $anio }}.
                    </td>
                </tr>
            @else
                @foreach($asociados as $asociado)
                    <tr>
                        <td class="px-2 py-2 border text-center text-gray-600">
                            {{ $loop->iteration }}
                        </td>
                        <td class="px-3 py-2 border text-center font-mono">
                            {{ $asociado->matricula }}
                        </td>
                        <td class="px-4 py-2 border text-left">
                            {{ $asociado->nombreFormateado($orden) }}
                        </td>
                        @for ($m = 1; $m <= 12; $m++)
                            @php
                                $asistio = $asistenciaMatrix[$asociado->matricula][$m] ?? false;
                                if ($asistio) $totales[$m]++;
                            @endphp
                            <td class="px-2 py-2 border text-center">
                                {{ $asistio ? '✔️' : '—' }}
                            </td>
                        @endfor
                    </tr>
                @endforeach

                {{-- Totales --}}
                <tr class="bg-gray-200 font-bold">
                    <td colspan="3" class="px-4 py-2 border text-right">
                        Total ({{ $asociados->count() }} asociados)
                    </td>
                    @for ($m = 1; $m <= 12; $m++)
                        <td class="px-2 py-2 border text-center">{{ $totales[$m] }}</td>
                    @endfor
                </tr>
            @endif
        </tbody>
    </table>
</body>
</html>
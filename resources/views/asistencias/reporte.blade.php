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
    <h2 class="text-base font-bold mb-2 text-center">
        {{ $asociacion }}
    </h2>
    <h2 class="text-base font-bold mb-2 text-center">
        Reporte de Asistencias - Año {{ $anio }}
    </h2>

    <table class="w-full border border-gray-300 text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 border">Asociado</th>
                @for ($m = 1; $m <= 12; $m++)
                    <th class="px-2 py-2 border">{{ \Carbon\Carbon::create()->month($m)->format('M') }}</th>
                @endfor
            </tr>
        </thead>
        <tbody>
            @php $totales = array_fill(1, 12, 0); @endphp

            @if($asociados->isEmpty())
                <tr>
                    <td colspan="13" class="px-4 py-6 text-center text-gray-500 italic">
                        🚫 No hay asistencias registradas en {{ $anio }}.
                    </td>
                </tr>
            @else
                @foreach($asociados as $asociado)
                    <tr>
                        <td class="px-4 py-2 border text-left">{{ $asociado->nombre . ' ' . $asociado->apellido }}</td>
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
                    <td class="px-4 py-2 border text-right">Total</td>
                    @for ($m = 1; $m <= 12; $m++)
                        <td class="px-2 py-2 border text-center">{{ $totales[$m] }}</td>
                    @endfor
                </tr>
            @endif
        </tbody>
    </table>
</body>
</html>

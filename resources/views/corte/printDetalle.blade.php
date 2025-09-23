<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Corte Mensual Detallado</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body onload="window.print(); window.onafterprint = function(){ window.location.href='{{ route('asociados.index') }}'; }">
    <div class="w-80 mx-auto text-center font-mono text-sm">
        <h2 class="text-lg font-bold mb-2">{{ $general->asociacion }}</h2>
        <p class="mb-2">📋 Detalle de Recibos - {{ $general->aniomes }}</p>
        <div class="border-t border-dashed border-gray-700 my-2"></div>

        <table class="w-full text-left text-xs">
            <thead>
                <tr class="border-b border-gray-400">
                    <th class="px-1 py-1">Folio</th>
                    <th class="px-1 py-1">Fecha</th>
                    <th class="px-1 py-1">Matrícula</th>
                    <th class="px-1 py-1">Nombre</th>
                    <th class="px-1 py-1 text-right">Importe</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recibos as $recibo)
                <tr class="border-b border-dashed border-gray-300">
                    <td class="px-1 py-1">{{ $recibo->aniomes . '_' .$recibo->foliomes }}</td>
                    <td class="px-1 py-1">{{ \Carbon\Carbon::parse($recibo->fecha)->format('d/m/Y') }}</td>
                    @if($recibo->cancelado)
                        <td class="px-1 py-1">{{ $recibo->matricula_a }}</td>
                        <td class="px-1 py-1">Cancelado</td>
                        <td class="px-1 py-1 text-right">${{ number_format(0, 2) }}</td>                    
                    @else
                        <td class="px-1 py-1">{{ $recibo->matricula }}</td>
                        <td class="px-1 py-1">{{ $recibo->asociado->nombre }}</td>
                        <td class="px-1 py-1 text-right">${{ number_format($recibo->importe, 2) }}</td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>

        <p><span class="font-semibold">Total Aportaciones:</span> 
           <span class="text-green-600 font-bold">${{ number_format($totalImporte, 2) }}</span>
        </p>

        <div class="border-t border-dashed border-gray-700 my-2"></div>
        <p class="text-gray-600">Fecha de Corte: {{ now()->format('d/m/Y H:i') }}</p>
        <p class="mt-2">-- Fin del reporte --</p>
    </div>
</body>
</html>

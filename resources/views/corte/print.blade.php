<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Corte Mensual</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body onload="window.print(); window.onafterprint = function(){ window.location.href='{{ route('asociados.index') }}'; }">
    <div class="w-72 mx-auto text-center font-mono text-sm">
        <h2 class="text-lg font-bold mb-2">{{ $general->asociacion }}</h2>
        <div class="border-t border-dashed border-gray-700 my-2"></div>

        <p><span class="font-semibold">Corte del Mes:</span> {{ $general->aniomes }}</p>
        <p><span class="font-semibold">Total Aportaciones:</span> 
           <span class="text-green-600 font-bold">${{ number_format($totalImporte, 2) }}</span>
        </p>
        <p><span class="font-semibold">Asistentes:</span> {{ $totalAsistentes }}</p>
        @if ($totalCancelado)
            <p><span class="font-semibold">Recibos cancelados:</span> {{ $totalCancelado }}</p>
        @endif

        <div class="border-t border-dashed border-gray-700 my-2"></div>

        <p class="text-gray-600">Fecha: {{ now()->format('d/m/Y H:i') }}</p>
        <p class="mt-2">-- Fin del reporte --</p>
    </div>
</body>
</html>

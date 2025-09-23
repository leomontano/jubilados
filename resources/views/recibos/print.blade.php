<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recibo</title>
    <style>
        body { font-family: monospace; font-size: 14px; }
        .ticket { width: 250px; max-width: 250px; }
        .center { text-align: center; }
        .bold { font-weight: bold; }
        hr { border: 1px dashed #000; margin: 10px 0; }
    </style>
</head>
<body onload="window.print(); setTimeout(() => window.location.href='{{ route('asociados.index') }}', 500);">
    <div class="ticket">
        <div class="center bold">{{ $general->asociacion }}</div>
        <hr>
        <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($recibo->fecha)->format('d/m/Y') }}</p>
        <p><strong>Matrícula:</strong> {{ $recibo->asociado->matricula }}</p>
        <p><strong>Nombre:</strong> {{ $recibo->asociado->nombre }} {{ $recibo->asociado->apellido }}</p>
        <hr>
        <p><strong>Aportación:</strong> ${{ number_format($recibo->importe, 2) }}</p>
        <p><strong>Son:</strong> {{ $importeLetras }} pesos M.N.</p>

    @if($esReimpresion)
        <p class="mt-2 text-red-600 font-semibold center">*** ¡Reimpresión ***</p>
    @endif

        <div class="center">¡Gracias por su aportación!</div>
    </div>
</body>
</html>
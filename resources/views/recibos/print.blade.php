{{-- <!DOCTYPE html>
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
        <hr>
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
    <hr>
</body>
</html> --}}

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recibo</title>
    <style>
        @media print {
            @page {
                size: 58mm auto; /* ancho fijo 58mm, alto dinámico */
                margin: 0;
            }
            body {
                font-family: monospace, sans-serif;
                font-size: 12px;
                margin: 0;
                padding: 0;
                width: 58mm;
            }
            .ticket {
                width: 100%;
                text-align: center;
            }
            .ticket h2 {
                font-size: 14px;
                margin: 5px 0;
            }
            .ticket p {
                margin: 2px 0;
            }
            .line {
                border-top: 1px dashed #000;
                margin: 5px 0;
            }
            .totales {
                margin-top: 10px;
                text-align: right;
                font-weight: bold;
            }
        }
    </style>
</head>
<body>
    <div class="ticket">
        <h2>{{ $general->asociacion }}</h2>
        <p><strong>Matrícula:</strong> {{ $recibo->asociado->matricula }}</p>
        <div class="line"></div>
        <p>Recibo No: {{ $recibo->id }}</p>
        <p>Fecha: {{ \Carbon\Carbon::parse($recibo->fecha)->format('d/m/Y') }}</p>
        <div class="line"></div>
        <p>Asociado: {{ $recibo->asociado->nombre }} {{ $recibo->asociado->apellido }}</p>
        <p>Matricula: {{ $recibo->asociado->matricula }}</p>
        <div class="line"></div>
        <p>Importe: ${{ number_format($recibo->importe, 2) }}</p>
        <p><strong>Son:</strong> {{ $importeLetras }} pesos M.N.</p>
        @if($recibo->cancelado)
            <p style="color:red; font-weight:bold;">*** CANCELADO ***</p>
        @endif
        <div class="line"></div>
        <p>¡Gracias por su aportación!</p>
            {{-- 🔹 Simulación de corte --}}
        <div class="cut"></div>
        <div class="spacer"></div>
    </div>
</body>
</html>
<script>
    window.onload = function() {
        window.print();
    };
</script>


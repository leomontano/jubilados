<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recibo</title>
    <style>
        body {

            font-family: monospace;
            width: 280px; /* 80mm real */
            margin: 0;
            padding: 0;

        }

        @page {
            size: 80mm auto;
            margin: 5mm;
        }
        
        .center { text-align: center; }
        .line { border-top: 1px dashed #000; margin: 5px 0; }
        .cut {
            border-top: 2px dashed #000;
            margin: 15px 0;
        }
        .spacer {
            height: 120px; /* simula el espacio para corte */
        }
    </style>
</head>
<body onload="window.print(); setTimeout(() => window.location.href='{{ route('asociados.index') }}', 500);">
    <div class="center">
        <h3>{{ $general->asociacion }}</h3>
        <p>&nbsp;</p>
        {{-- <small>Presidente: {{ $general->presidente }}</small> --}}
    </div>

    <div class="line"></div>
    <p>Recibo No: {{ $recibo->id }}</p>
    <p>Recibo No: {{ $recibo->aniomes . '_' . str_pad($recibo->foliomes, 3, "0", STR_PAD_LEFT); }}</p>
    <p>Fecha: {{ \Carbon\Carbon::parse($recibo->fecha)->format('d/m/Y') }}</p>
    <p>Asociado: {{ $asociado->nombre . ' ' . $asociado->apellido }}</p>
    <p>Matrícula: {{ $asociado->matricula }}</p>
    <p>&nbsp;</p>
    <p>Importe: ${{ number_format($recibo->importe, 2) }}</p>
    <p>Son {{ $importeLetras }} pesos M.N.</p>

    @if($recibo->cancelado)
        <div class="center">
            <strong>*** CANCELADO ***</strong>
        </div>
    @else
        @if($esReimpresion)
            <div class="center">
                <strong>*** Reimpresión ***</strong>
            </div>
        @endif
    @endif





    <div class="line"></div>
    <p>&nbsp;</p>
    <div class="center">
        <p>¡Gracias por su aportación!</p>
    </div>

    {{-- 🔹 Simulación de corte --}}
    <div class="cut"></div>
    <div class="spacer"></div>

<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>

</body>
</html>






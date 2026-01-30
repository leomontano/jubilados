<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <title>Recibo</title>

    <style>
        /* CONFIGURACIÓN GENERAL */
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

        /* UTILIDADES */
        .center { text-align: center; }
        .right  { text-align: right; }
        .line   { border-top: 1px dashed #000; margin: 6px 0; }

        h1 {
            font-size: 16px;
            margin: 4px 0;
        }

        p {
            font-size: 12px;
            margin: 2px 0;
        }

        .bold {
            font-weight: bold;
        }

        .spacer {
            height: 120px; /* MUY IMPORTANTE: evita que se coma la última línea */
        }
    </style>
</head>

<body
    onload="
        window.print();
        setTimeout(() => window.location.href='{{ route('asociados.index') }}', 700);
    "
>

    {{-- ENCABEZADO --}}
    <div class="center">
        <h1>{{ $general->asociacion }}</h1>
        <p>{{ $general->presidente }}</p>
    </div>

    <div class="line"></div>

    {{-- DATOS DEL RECIBO --}}
    <p><span class="bold">Fecha:</span>
        {{ \Carbon\Carbon::parse($recibo->fecha)->format('d/m/Y') }}
    </p>

    <p><span class="bold">Recibo:</span> {{ $recibo->id }}</p>
    <p><span class="bold">Matrícula:</span> {{ $asociado->matricula }}</p>
    <p><span class="bold">Nombre:</span> {{ $asociado->nombre }}</p>

    <div class="line"></div>

    {{-- IMPORTE --}}
    <p class="bold right">
        IMPORTE: ${{ number_format($recibo->importe, 2) }}
    </p>

    <div class="line"></div>

    {{-- ASISTENCIA --}}
    <p>
        Asistió:
        {{ $recibo->asistio ? 'SÍ' : 'NO' }}
    </p>

    @if($recibo->cancelado)
        <div class="center">
            <p class="bold">*** RECIBO CANCELADO ***</p>
        </div>
    @endif

    <div class="line"></div>

    {{-- PIE --}}
    <div class="center">
        <p>Gracias por su aportación</p>
        <p>Conserve este comprobante</p>
    </div>

    {{-- ESPACIO EXTRA PARA CORTE --}}
    <div class="spacer"></div>

</body>
</html>






<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Corte Mensual</title>
    <script src="https://cdn.tailwindcss.com"></script>

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

    @php
        $total_mesT=0;
        $numero_recibosT=0;
        $personasT=0;
        $importe_retroactivos=0;
        $personas_con_retroactivos=0;
        $cuotames=0;
        foreach ($resultados as $resultado) {
            if($cuotames==0){
                $cuotames=$resultado->total_por_matricula;
            } else {
                $importe_retroactivos+= ($resultado->total_por_matricula-$cuotames )* $resultado->personas;
                $personas_con_retroactivos+=$resultado->personas;
            }
            $total_mesT+=$resultado->total_mes;
            $numero_recibosT+=$resultado->numero_recibos;
            $personasT+=$resultado->personas;
        }
        $aportacionesdelmes=$total_mesT-$importe_retroactivos;
    @endphp 

<body onload="window.print(); window.onafterprint = function(){ window.location.href='{{ route('asociados.index') }}'; }">
    <div class="w-72 mx-auto text-center font-mono text-sm">

    <div class="center">
         <p>&nbsp;</p>
         <p>----------------------</p>
    </div>
        <div class="center">
         <p>&nbsp;</p>
    </div>

        <h2 class="text-lg font-bold mb-2">{{ $general->asociacion }}</h2>
        <div class="border-t border-dashed border-gray-700 my-2"></div>

        <p><span class="font-semibold">Corte del Mes:</span> {{ $general->aniomes }}</p>

        <p><span class="font-semibold">Personas que aportaron mes actual:</span> 
           <span class="text-green-600 font-bold">{{ number_format($personasT) }}</span>
        </p>
        <p><span class="font-semibold">personas que dieron retroactivo:</span> 
           <span class="text-green-600 font-bold">{{ number_format($personas_con_retroactivos) }}</span>
        </p>

        <p><span class="font-semibold">Aportaciones del mes actual:</span> 
           <span class="text-green-600 font-bold">${{ number_format($total_mesT - $importe_retroactivos) }}</span>
        </p>
        <p><span class="font-semibold">Importe de retroactivos:</span> 
           <span class="text-green-600 font-bold">${{ number_format($importe_retroactivos) }}</span>
        </p>

        <p><span class="font-semibold">Total de aportaciones:</span> 
           <span class="text-green-600 font-bold">${{ number_format($total_mesT) }}</span>
        </p>


        @if ($totalAsistentes)
            <p><span class="font-semibold">Asistentes:</span> {{ $totalAsistentes->totalAsistentes }}</p>
        @endif
        @if ($totalCancelado)
            <p><span class="font-semibold">Recibos cancelados:</span> {{ $totalCancelado }}</p>
        @endif

        <div class="border-t border-dashed border-gray-700 my-2"></div>

        <p class="text-gray-600">Fecha: {{ now()->format('d/m/Y H:i') }}</p>
        <div class="center">
         <p>&nbsp;</p>
        </div>
        <p class="mt-2">-- Fin del reporte --</p>
    </div>
</body>
</html>
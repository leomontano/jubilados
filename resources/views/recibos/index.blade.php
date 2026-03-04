<x-layout meta-title="Recibo" meta-description="Recibo Description">
<div class="max-w-6xl mx-auto p-6 bg-white rounded-lg shadow-md">

    {{-- Filtro de Mes y Año --}}
    <form method="GET" action="{{ route('recibo') }}" class="flex space-x-4 mb-6">
        {{-- Mes --}}
        <div>
            <label for="mes" class="block text-sm font-medium text-gray-700">Mes</label>
            <select name="mes" id="mes" class="border-gray-300 rounded-lg shadow-sm">
                @foreach(range(1,12) as $m)
                    <option value="{{ $m }}" {{ $m == $mes ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Año --}}
        <div>
            <label for="anio" class="block text-sm font-medium text-gray-700">Año</label>
            <select name="anio" id="anio" class="border-gray-300 rounded-lg shadow-sm">
                @foreach(range(now()->year, now()->year - 10) as $y)
                    <option value="{{ $y }}" {{ $y == $anio ? 'selected' : '' }}>
                        {{ $y }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex items-end">
            <button type="submit"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
                🔍 Filtrar
            </button>
        </div>
    </form>

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

    <h2 class="text-2xl font-bold mb-4">
        Recibos del mes de {{ $nombremes }}
    </h2>

    <table class="w-full border-collapse border border-gray-300 mb-4">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="border border-gray-300 px-4 py-2">Folio</th>
                <th class="border border-gray-300 px-4 py-2">Fecha</th>
                <th class="border border-gray-300 px-4 py-2">Matrícula</th>
                <th class="border border-gray-300 px-4 py-2">Nombre</th>
                <th class="border border-gray-300 px-4 py-2 text-right">Importe</th>
                <th colspan="2" class="border border-gray-300 px-4 py-2 text-center">Acción</th>

            </tr>
        </thead>
        <tbody>
        @php
            $hoy=date("Ym");
        @endphp
            @forelse($recibos as $recibo)
                <tr class="{{ $recibo->cancelado === 1 ? 'bg-red-100 text-red-700' : 'hover:bg-gray-100' }}">

                    <td class="border border-gray-300 px-4 py-2">{{ $recibo->aniomes .'_'. $recibo->foliomes }}</td>
                    <td class="border border-gray-300 px-4 py-2">
                        {{ $recibo->created_at }}
                    </td>



                    <td class="border border-gray-300 px-4 py-2">
                        @if ( $recibo->matricula )
                            <a href="{{ route('recibomatricula', $recibo->matricula) }}"
                               class="inline-block px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-1 transition">{{ $recibo->matricula }}</a>
                        @else
                            {{ $recibo->matricula_a }} (Asociado eliminado)
                        @endif
                    </td>
                    <td class="border border-gray-300 px-4 py-2">
                        {{ $recibo->asociado->nombre ?? 'Sin nombre' }} {{ $recibo->asociado->apellido }}
                    </td>
                    <td class="border border-gray-300 px-4 py-2 text-right">
                        ${{ number_format($recibo->importe, 2) }}
                    </td>
                   <td class="border border-gray-300 px-4 py-2 text-center">
                        @if ($recibo->cancelado === 0)
                            <a href="{{ route('recibos.print', ['id' => $recibo->id, 'reimpresion' => 1]) }}"
                               target="_blank"
                               class="px-3 py-1 bg-orange-500 hover:bg-orange-600 text-white text-sm font-medium rounded-lg shadow">
                                🔄 Reimprimir
                            </a>                                
                        @else
                            {{ $recibo->cancelado === 1 ? 'Cancelado' : '' }}
                        @endif
                    </td>
                    <td class="border border-gray-300 px-4 py-2 text-center">
                       {{-- Verificar si es del mes y año actual y si no está cancelado --}}

                        @if ($recibo->aniomes === $hoy and $recibo->cancelado === 0)
                            {{-- Botón con modal de confirmación --}}
                            <div x-data="{ open: false }" class="inline-block">
                                <button @click="open = true"
                                    class="px-3 py-1 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700 transition">
                                    🗑️ Eliminar
                                </button>

                                <!-- Modal -->
                                <div x-show="open"
                                     class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
                                     x-cloak>
                                    <div class="bg-white rounded-xl shadow-lg p-6 w-80 text-center">
                                        <h3 class="text-lg font-semibold text-gray-800 mb-4">⚠️ Confirmar eliminación</h3>
                                        <p class="text-sm text-gray-600 mb-6">
                                            ¿Seguro que deseas eliminar el recibo <strong>#{{ $recibo->aniomes .'_'. $recibo->foliomes}} de {{ $recibo->asociado->nombre }} {{ $recibo->asociado->apellido }}, por un importe de ${{ $recibo->importe }} </strong>?
                                        </p>
                                        <div class="flex justify-center space-x-3">
                                            <form action="{{ route('recibos.destroy', $recibo->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                                                    Sí, eliminar
                                                </button>
                                            </form>
                                            <button @click="open = false"
                                                class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                                                Cancelar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </td>


{{--                     <td>
                        <a href="{{ route('recibos.printTicket', $recibo->id) }}" 
   class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
   🖨️ Imprimir Ticket</a>

                    </td> --}}

                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-4">No hay recibos este mes</td>
                </tr>
            @endforelse
        {{-- Total del mes --}}
            <tr>
                <td></td><td></td><td></td>
                <td>Total del mes:</td>
                <td class="text-right font-bold text-lg">${{ number_format($total_mesT, 2) }}</td>
            </tr>

        </tbody>
    </table>

    {{-- Paginación --}}
    <div class="mb-4">
        {{ $recibos->links() }}
    </div>


    @if($cancelados->totalCancelados or $cancelados->sumaCancelados)
        <div class="p-4 bg-red-100 border border-red-400 rounded-md text-red-700">
            <p>📋 Total de recibos cancelados: <strong>{{ $cancelados->totalCancelados }}</strong></p>
            <p>💰 Suma de importes cancelados: <strong>${{ number_format($cancelados->sumaCancelados, 2) }}</strong></p>
        </div>
    @endif

    <div class="p-4 bg-black-100 border border-black-400 rounded-md text-black-700">
        @if($numero_recibosT)
                <p>📋 Total de recibos: <strong>{{ ($numero_recibosT) }}</strong></p>
        @endif

        @if($personasT)
                <p>📋 Personas que aportaron: <strong>{{ ($personasT) }}</strong></p>
        @endif

        @if($personas_con_retroactivos)
                <p>📋 Total de personas que dieron retroactivo: <strong>{{ $personas_con_retroactivos }}</strong></p>
        @endif

        @if($total_mesT)
                <p>💰 Aportaciones del mes: <strong>$ {{ number_format($total_mesT - $importe_retroactivos) }}</strong></p>
        @endif

        @if($importe_retroactivos)
                <p>💰 Importe de retroactivos: <strong>$ {{ number_format($importe_retroactivos) }}</strong></p>
        @endif

        @if($total_mesT)
                <p>💰 Suma de aportaciones: <strong>$ {{ number_format($total_mesT) }}</strong></p>
        @endif
    </div>


<div class="p-4 bg-black-100 border border-black-400 rounded-md text-black-700">
    <table class="w-full border-collapse border border-gray-300 mb-4">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="border border-gray-300 px-4 py-2 text-center">Cuota</th>
                <th class="border border-gray-300 px-4 py-2 text-center">💰 Suma</th>
                <th class="border border-gray-300 px-4 py-2 text-center">📋 No. Recibos</th>
                <th class="border border-gray-300 px-4 py-2 text-center">📋 No. Personas</th>
            </tr>
        </thead>
        <tbody>

            @forelse($resultados as $resultado)
                <tr class="hover:bg-gray-100">
                    <td class="border border-gray-300 px-4 py-2 text-center">${{ $resultado->total_por_matricula }}  {{ $resultado->total_por_matricula > $cuota ? '( Con Retroactivo)' : '' }}</td>
                    <td class="border border-gray-300 px-4 py-2 text-right">${{ number_format($resultado->total_mes) }}</td>
                    <td class="border border-gray-300 px-4 py-2 text-center">{{ $resultado->numero_recibos }}</td>
                    <td class="border border-gray-300 px-4 py-2 text-center">{{ $resultado->personas }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-4">No hay recibos este mes</td>
                </tr>
            @endforelse
                                {{-- Totales --}}
            <tr class="bg-gray-200 font-bold">
                <td class="px-4 py-2 border text-center">Totales</td>
                <td class="px-2 py-2 text-center text-right">${{ number_format($total_mesT) }}</td>
                <td class="px-2 py-2 border text-center">{{ $numero_recibosT }}</td>
                <td class="px-2 py-2 border text-center">{{ $personasT }}</td>
            </tr>
        </tbody>
    </table>
</div>
</div>
</x-layout>

{{-- @dump($asociado->toArray() ) --}}

@php
    use Carbon\Carbon;
    $now = Carbon::now();
@endphp

<x-layout meta-title="Asociado" meta-description="Relación de asociados">


        <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-2xl font-bold text-gray-700 mb-4">
                Recibos de: {{ $asociado->nombre }} {{ $asociado->apellido }} (Matrícula: {{ $asociado->matricula }})
            </h2>

            @if ($recibos->isEmpty())
                <p class="text-red-500">No se encontraron recibos para este asociado.</p>
            @else
                <table class="w-full border-collapse">
                    <thead>
                        <tr>
                            <td class="bg-blue-100 text-center font-semibold py-2 border">
                                Folio
                            </td>
                            <td class="bg-blue-100 text-center font-semibold py-2 border">
                                Fecha
                            </td>
                            <td class="bg-blue-100 text-center font-semibold py-2 border">
                                Importe
                            </td>
                            <td colspan="2" class="bg-blue-100 text-center font-semibold py-2 border">
                               Acción
                            </td>
                        </tr>

                    </thead>
                    <tbody>
                        @php
                            $hoy=date("Ym");
                        @endphp
                        @foreach ($recibos as $recibo)
                            <tr class="{{ $recibo->cancelado === 1 ? 'bg-red-100 text-red-700' : 'hover:bg-gray-100' }}">
                                <td class="p-2 border">{{ $recibo->aniomes .'_'. $recibo->foliomes }}</td>
                                <td class="p-2 border">{{ $recibo->created_at }}</td>
                                <td class="p-2 border text-right">${{ number_format($recibo->importe, 2) }}</td>
                                <td class="p-2 border text-center">
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
                                <td class="p-2 border text-center">
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
                                                    ¿Seguro que deseas eliminar el recibo <strong>#{{ $recibo->aniomes .'_'. $recibo->foliomes}} de {{ $asociado->nombre }} {{ $asociado->apellido }}, por un importe de ${{ $recibo->importe }} </strong>?
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
                            </tr>
                        @endforeach
                        {{-- Fila del total --}}
                        <tr class="bg-gray-100 font-bold">
                            <td colspan="2" class="p-2 border text-right">TOTAL</td>
                            <td class="p-2 border text-right">
                                ${{ number_format($totalImporte, 2) }}
                                {{-- o $totalImporte si lo calculaste en el controlador --}}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $recibos->links() }}
                </div>
                <a href="{{ url()->previous() }}"
                    class="inline-block px-4 py-2 bg-gray-500 text-white rounded-lg shadow hover:bg-gray-600 transition">🔙 Regresar
                </a>
            @endif
        </div>

</x-layout>

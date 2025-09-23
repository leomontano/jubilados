<x-layout :meta-title="$asociado->nombre .' ' .$asociado->apellido" :meta-description="$asociado->matricula .' ' .$asociado->nombre .' ' .$asociado->apellido">

    <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg p-6">


        <div class="\-mt-8 flex items-center justify-center space-x-10" >
            <a class="rounded-full bg-sky-600 p-4 text-sky-100 shadow-lg hover:bg-sky-700 active:bg-sky-800"
                href="{{ route('asociados.edit', $asociado) }}">
                <svg
                  class="h-6 w-6"
                  data-slot="icon"
                  fill="none"
                  stroke-width="1.5"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg"
                  aria-hidden="true"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125"
                  ></path>
                </svg>
            </a>
            <td class="border border-gray-300 px-4 py-2 text-center">
                    {{-- Botón con modal de confirmación --}}
                <div x-data="{ open: false }" class="inline-block">
                    <button  @click="open = true" class="rounded-full bg-red-600 p-4 text-red-100 shadow-lg hover:bg-red-700 active:bg-red-800">
                    <svg
                      class="h-6 w-6"
                      data-slot="icon"
                      fill="none"
                      stroke-width="1.5"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                      xmlns="http://www.w3.org/2000/svg"
                      aria-hidden="true"
                    >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"
                      ></path>
                    </svg>
                    </button>
                    <!-- Modal -->
                    <div x-show="open"
                         class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
                         x-cloak>
                        <div class="bg-white rounded-xl shadow-lg p-6 w-80 text-center">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">⚠️ Confirmar eliminación</h3>
                            <p class="text-sm text-gray-600 mb-6">
                                ¿Seguro que deseas eliminar el asociado <strong>{{ $asociado->nombre }} {{ $asociado->apellido }}</strong>?
                            </p>
                            <div class="flex justify-center space-x-3">
                                <form action="{{ route('asociados.destroy', $asociado) }}" method="POST">
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
            </td>
        </div>


        <h2 class="text-2xl font-bold text-blue-700 mt-4">Nombre: {{ $asociado->nombre }} {{ $asociado->apellido }}
        </h2>
        <div class="text-xl font-bold text-gray-700 mb-4">
            <h3 class="text-blue-500">Matrícula: {{ $asociado->matricula }}</h3>
            <p>{{ 'Fecha de nacimiento: ' .  $asociado->fecha_nacimiento }}</p>

            @if ($asociado->fecha_nacimiento)
            <p class="text-green-700">{{ \Carbon\Carbon::parse($asociado->fecha_nacimiento)->age }} años de edad
            </p>
            @endif


            <p>{{ 'Fecha de '. ($asociado->puesto === 'P' ? 'pensión:' : 'jubilación:') }}
                            {{ $asociado->fecha_jubilacion }}
            </p>
            @if ($asociado->fecha_jubilacion)
            <p class="text-green-700">{{ \Carbon\Carbon::parse($asociado->fecha_jubilacion)->age }} años {{ 'de '. ($asociado->puesto === 'P' ? 'pensionado' : 'jubilado') }}
            </p>
            @endif



            <p>{{ 'Fecha de nacimiento: ' .  $asociado->fecha_nacimiento }}, ( {{ \Carbon\Carbon::parse($asociado->fecha_nacimiento)->age }} años de edad )</p>
            <p>{{ 'Teléfono/celular: ' .  $asociado->celular }}</p>
        </div>

        <a href="{{ route('asociados.index') }}" class="mt-6 px-4 py-2 bg-gray-500 text-white rounded-lg 
          hover:bg-gray-600 mt-4">
                    ⬅️ Regresar
        </a>

    </div>
    </div>
</x-layout>


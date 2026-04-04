<x-layout :meta-title="$asociado->nombre .' ' .$asociado->apellido" :meta-description="$asociado->matricula .' ' .$asociado->nombre .' ' .$asociado->apellido">

<div class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg p-6">


    {{-- MENSAJES --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif


    {{-- TARJETA --}}
    <div class="bg-white shadow-lg rounded-lg p-6">

        <h2 class="text-2xl font-bold mb-6 text-gray-700">
            Detalle del Asociado
        </h2>

        <div class="grid grid-cols-3 gap-6">

            <div>
                <p class="text-2xl font-bold text-blue-700 mt-4">Matrícula: {{ $asociado->matricula }}</p>
            </div>

            <div>
                <p class="text-xl font-bold text-gray-700 mt-4">Nombre: {{ $asociado->nombre }}</p>
            </div>
            <div>
                <p class="text-xl font-bold text-gray-700 mt-4">Apellido: {{ $asociado->apellido }}</p>
            </div>


            <div>
                <p class="text-sm text-gray-500">Estado</p>
                <p class="text-lg font-semibold">
                    {{ $asociado->activo ? 'Activo' : 'Inactivo' }}
                </p>
            </div>

        </div>

        <hr class="my-6">

        {{-- BOTONES --}}
        <div class="flex space-x-4 mt-4">

            <button onclick="abrirModal()"
                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-4 py-2 rounded shadow">
                Cambiar Matrícula
            </button>

            <a href="{{ route('asociados.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded shadow">
                Regresar
            </a>

        </div>

    </div>

</div>


{{-- MODAL --}}
<div id="modalCambio"
     class="fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center">

    <div class="bg-white rounded-lg shadow-xl w-96 p-6">

        <h3 class="text-xl font-bold mb-4 text-gray-700">
            Cambiar Matrícula
        </h3>

        <form method="POST"
              action="{{ route('asociados.cambiarMatricula',$asociado->matricula) }}">

            @csrf
            @method('PUT')

            <div class="mb-4">

                <label class="block text-sm text-gray-600">
                    Matrícula actual
                </label>

                <input type="text"
                    value="{{ $asociado->matricula }}"
                    readonly
                    name="matricula_actual"
                    class="w-full border rounded px-3 py-2 bg-gray-100">
            </div>
            <div class="mb-4">

                <label class="block text-sm text-gray-600">
                    Nueva matrícula
                </label>

                        <input type="number" 
                               name="matricula_nueva" required
                               placeholder="Nueva Matrícula"
                               value="{{ old('matricula_nueva') }}"
                               class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200" />
                        @error('matricula_nueva')
                            <br />
                            <small style="color: red">{{ $message }}</small>
                        @enderror
            </div>


            <div class="bg-red-100 border border-red-300 text-red-700 p-3 rounded mb-4 text-sm">

                Este cambio modificará registros en:

                <ul class="list-disc ml-5 mt-2">
                    <li>Asociados</li>
                    <li>Recibos</li>
                    <li>Asistencias</li>
                </ul>

                Esta acción no se puede deshacer.

            </div>


            <div class="flex justify-end space-x-3">

{{--                 <button type="button"
                    onclick="cerrarModal()"
                    class="bg-blue-400 hover:bg-blue-500 text-white px-4 py-2 rounded">
                    Cancelar
                </button> --}}


                <a href="{{ route('asociados.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded shadow">
                    Regresar
                </a>


                <button type="submit"
                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                    Confirmar
                </button>

            </div>

        </form>

    </div>

</div>


{{-- SCRIPT MODAL --}}
<script>

function abrirModal()
{
    document.getElementById('modalCambio').classList.remove('hidden');
    document.getElementById('modalCambio').classList.add('flex');
}

function cerrarModal()
{
    document.getElementById('modalCambio').classList.remove('flex');
    document.getElementById('modalCambio').classList.add('hidden');
}

</script>


</x-layout>
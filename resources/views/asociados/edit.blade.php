<x-layout :meta-title="$asociado->nombre .' ' .$asociado->apellido" :meta-description="$asociado->matricula .' ' .$asociado->nombre .' ' .$asociado->apellido">

    {{-- @dump($asociado->toArray()) --}}




<div class="max-w-2xl mx-auto bg-white p-6 rounded-2xl shadow-lg">


    <!-- Formulario -->
    <form action="{{ route('asociados.update', $asociado) }}" method="POST">
        @csrf  @method('PATCH')

    <h2 class="my-4 text-center font-serif text-3xl font-extrabold text-sky-600 md:text-3xl">Actualizar datos</h2>

        <!-- Datos del asociado -->
        <div class="mb-4">
            <h1 class="text-gray-600 text-2xl"><strong>Nombre:</strong> {{ $asociado->nombre }} {{ $asociado->apellido }}</h1>
            <h2 class="text-gray-600 text-2xl"><strong>Matrícula:</strong> {{ $asociado->matricula }}</h2>

        </div>
        <input type="number" name="matricula" value="{{ $asociado->matricula }}" hidden>

        @include('asociados.forms-fields')

        <div class="flex justify-center space-x-4">
            <a href="{{ route('asociados.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                ⬅️ Regresar
            </a>
            <button type="submit" 
                class="flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:scale-105">
                <svg xmlns="http://www.w3.org/2000/svg" 
                     fill="none" 
                     viewBox="0 0 24 24" 
                     stroke="currentColor" 
                     class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M17 16v2a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h2m4 0h6a2 2 0 012 2v2m-6 4h.01M6 20h12a2 2 0 002-2V10l-4-4H6a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                Grabar
            </button>
        </div>
    </form>
</div>





</x-layout>



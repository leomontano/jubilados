 {{-- @dump($asociados->toArray() ) --}}
<x-layout meta-title="Asociado" meta-description="Relación de asociados">

<div class="max-w-2xl mx-auto bg-white p-6 rounded-2xl shadow-lg">
    <h2 class="my-4 text-center font-serif text-3xl font-extrabold text-sky-600 md:text-3xl">Registrar Recibo</h2>
    <!-- Datos del asociado -->
    <div class="mb-4">
        <p class="text-gray-600 text-2xl"><strong>Matrícula:</strong> {{ $asociado->matricula }}</p>
        <p class="text-gray-600 text-2xl"><strong>Nombre:</strong> {{ $asociado->nombre }} {{ $asociado->apellido }}</p>
    </div>

    <!-- Formulario -->
    <form action="{{ route('recibos.store') }}" method="POST" class="space-y-4">
        @csrf
        <input type="hidden" name="matricula" value="{{ $asociado->matricula }}">



        <div class="flex items-center space-x-4 text-xl">
            <label for="importe" class="font-medium">Importe de la aportación:</label>
            <input 
                type="number" 
                name="importe" 
                id="importe"
                min="1" 
                step="0.01"
                placeholder="0.00"
                 value="{{ old('importe', $recibo->importe) }}"
                class="border rounded-lg px-3 py-2 w-32 text-right"
                required
            >
            @error('importe')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror                
        </div>

        <!-- Asistencia -->


        <div class="flex items-center space-x-4 text-xl">
            <span>¿Asistió a la reunión?</span>

            <label class="flex items-center space-x-1">
                <input type="radio" name="asistio" value="1" class="form-radio text-green-600">
                <span>Sí</span>
            </label>

            <label class="flex items-center space-x-1">
                <input type="radio" name="asistio" value="0" class="form-radio text-red-600">
                <span>No</span>
            </label>

            @error('asistio')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            
        </div>




        <!-- Botones -->
        <div class="flex justify-center space-x-4">
            <a href="{{ route('asociados.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                ⬅️ Regresar
            </a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                💾 Guardar Recibo
            </button>
        </div>
    </form>
</div>

</x-layout>
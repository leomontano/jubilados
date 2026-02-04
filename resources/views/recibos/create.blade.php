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
    <form action="{{ route('recibos.store') }}" method="POST" class="space-y-4" id="formRecibo">
        @csrf
        <input type="hidden" name="matricula" value="{{ $asociado->matricula }}">

        <input type="hidden" name="solo_asistencia" id="solo_asistencia" value="0">



        <div class="flex items-center space-x-4 text-xl">
            <label for="importe" class="font-medium">Importe de la aportación:</label>
            <input 
                type="number" 
                name="importe" 
                id="importe"
                min="0" 
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
                <input type="radio" name="asistio" value="1" class="form-radio text-green-600" checked>
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


    <div id="modalAsistencia" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
        <div class="bg-white rounded-lg p-6 w-96 text-center space-y-4">
            <h2 class="text-xl font-semibold">⚠️ Confirmación</h2>
            <p>
                El importe es <strong>$0</strong>.<br>
                ¿Deseas registrar <strong>solo la asistencia</strong>?
            </p>

            <div class="flex justify-center space-x-4">
                <button id="cancelarModal" class="px-4 py-2 bg-gray-500 text-white rounded">
                    Cancelar
                </button>
                <button id="confirmarAsistencia" class="px-4 py-2 bg-green-600 text-white rounded">
                    Sí, solo asistencia
                </button>
            </div>
        </div>
    </div>



</div>

</x-layout>


<script>
document.getElementById('formRecibo').addEventListener('submit', function (e) {
    const importe = parseFloat(document.getElementById('importe').value || 0);
    const asistio = document.querySelector('input[name="asistio"]:checked');

    // Si importe es 0 y asistió = Sí
    if (importe === 0 && asistio && asistio.value === '1') {
        e.preventDefault(); // Detiene el submit normal
        document.getElementById('modalAsistencia').classList.remove('hidden');
        document.getElementById('modalAsistencia').classList.add('flex');
    }
});

// Cancelar modal
document.getElementById('cancelarModal').addEventListener('click', function () {
    document.getElementById('modalAsistencia').classList.add('hidden');
});

// Confirmar solo asistencia
document.getElementById('confirmarAsistencia').addEventListener('click', function () {
    document.getElementById('solo_asistencia').value = 1;
    document.getElementById('formRecibo').submit();
});
</script>

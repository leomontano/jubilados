<x-layout meta-title="Recibo" meta-description="Recibo Description">

<div class="max-w-3xl mx-auto py-6">
    <h1 class="text-2xl font-bold mb-6">Editar Datos Generales</h1>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('generals.update') }}" method="POST" class="bg-white p-6 rounded shadow-md space-y-4">
        @csrf

        {{-- Asociación --}}
        <div>
            <label class="block font-semibold mb-1">Nombre de la Asociación:</label>
            <input type="text" name="asociacion" value="{{ old('asociacion', $general->asociacion) }}"
                class="w-full border px-3 py-2 rounded focus:outline-none focus:ring focus:border-blue-300">
            @error('asociacion')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        {{-- Presidente --}}
        <div>
            <label class="block font-semibold mb-1">Presidente:</label>
            <input type="text" name="presidente" value="{{ old('presidente', $general->presidente) }}"
                class="w-full border px-3 py-2 rounded focus:outline-none focus:ring focus:border-blue-300">
            @error('presidente')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        {{-- Cuota --}}
        <div>
            <label class="block font-semibold mb-1">Cuota Mensual:</label>
            <input type="number" name="cuota" value="{{ old('cuota', $general->cuota) }}" min="0" step="0.01"
                class="w-full border px-3 py-2 rounded focus:outline-none focus:ring focus:border-blue-300">
            @error('cuota')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        {{-- Timezone --}}
        <div>
            <label class="block font-semibold mb-1">Zona Horaria:</label>
            <select name="timezone" class="w-full border px-3 py-2 rounded focus:outline-none focus:ring focus:border-blue-300">
                @foreach($timezones as $tz => $label)
                    <option value="{{ $tz }}" {{ old('timezone', $general->timezone) == $tz ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            @error('timezone')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        {{-- Botón --}}
        <div class="flex justify-end">
            <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 focus:outline-none">
                Guardar Cambios
            </button>
        </div>
    </form>
</div>

</x-layout>

<x-layout meta-title="Asociado" meta-description="Registro de nuevos asociados">
    <div class="mx-auto mt-2 max-w-6xl">
        <h1 class="my-2 text-center font-serif text-3xl font-extrabold text-sky-600 md:text-3xl">Nuevo asociado</h1>
        <div class="flex items-center justify-center">
            <div class="max-w-md mx-auto bg-white shadow-lg rounded-lg p-6">
                <form action="{{ route('asociados.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="matricula" class="block text-sm font-medium text-gray-600">Matrícula</label>
                        <input type="number" 
                               name="matricula" 
                               id="importe" 
                               placeholder="Matrícula"
                               value="{{ old('matricula') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition" />
                        @error('matricula')
                            <br />
                            <small style="color: red">{{ $message }}</small>
                        @enderror
                    </div>

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
        </div>
    </div>
</x-layout>

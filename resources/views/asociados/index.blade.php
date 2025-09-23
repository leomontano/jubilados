 {{-- @dump($asociados->toArray() ) --}}
<x-layout meta-title="Asociado" meta-description="Relación de asociados">
    <div class="mx-auto mt-4 max-w-6xl">
        <h1 class="my-4 text-center font-serif text-4xl font-extrabold text-sky-600 md:text-5xl">Asociados</h1>
        <div class="flex items-center justify-center">
            <a href="{{ route('asociados.create') }}"
                class="group rounded-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 shadow-md transition duration-200">
                <svg
                    class="h-6 w-6 duration-300 group-hover:rotate-12"
                    data-slot="icon"
                    fill="none"
                    stroke-width="1.5"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                    aria-hidden="true">
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M12 4.5v15m7.5-7.5h-15">
                    </path>
                </svg>
            </a>

            <form action="{{ route('asociados.index') }}" method="GET">
                @csrf
                <input type="number" placeholder="Buscar por matricula"  name="matricula" value="{{ old('matricula') }}" style="margin-left:10px;">
                <input type="text" placeholder="Buscar por nombre" name="nombre"  value="{{ old('nombre') }}">
                <input type="text" placeholder="Buscar por apellido"  name="apellido"  value="{{ old('apellido') }}">
                <button type ="submit" class="rounded-full bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4  shadow-md transition duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                      <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </button>
            </form>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <strong>Ups, hubo algunos errores:</strong>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            
        </div>
        <div class="mx-auto mt-8 grid max-w-6xl gap-4 md:grid-cols-2 lg:grid-cols-3">
        @foreach ($asociados as $asociado)
          
            <article class="flex flex-col overflow-hidden rounded bg-white shadow dark:bg-slate-900">
              <div class="flex-1 space-y-3 p-5">
                <h3 class="text-xl font-semibold text-sky-500">
                  <a href="{{ route('asociados.show', $asociado->id) }}">Matrícula: {{ $asociado->matricula }}</a>
                </h3>
                <h2
                  class="text-xl font-semibold leading-tight text-slate-800 dark:text-slate-200"
                >
                  <a class="hover:underline" href="{{ route('asociados.show', $asociado) }}">
                    {{ $asociado->nombre . ' ' . $asociado->apellido }}
                  </a>
                </h2>
                <p class="hidden text-slate-500 dark:text-slate-400 md:block">
                    {{ 'Sexo: ' . $asociado->sexo }} | {{ $asociado->puesto == 'J' ? 'Jubilado' : 'Pensionado' }}
                </p>
                <p class="hidden text-slate-500 dark:text-slate-400 md:block">
                    {{ 'Fecha de registro: ' .  date_format($asociado->created_at, 'd/m/Y  H:i') }}
                </p>


                @isset($asociado->fecha_nacimiento)
                    <p class="hidden text-slate-500 dark:text-slate-400 md:block">
                        {{ 'Fecha de nacimiento: ' .  $asociado->fecha_nacimiento }}
                    </p>
                @endisset

                @isset($asociado->fecha_jubilacion)
                    <p class="hidden text-slate-500 dark:text-slate-400 md:block">
                       {{ 'Fecha de '. ($asociado->puesto === 'P' ? 'pensión:' : 'jubilación:' . ':') }} {{ $asociado->fecha_jubilacion }}
                    </p>
                @endisset

                @isset($asociado->celular)
                    <p class="hidden text-slate-500 dark:text-slate-400 md:block">
                        {{ 'Telefono/Celular: ' .  $asociado->celular }}
                    </p>
                @endisset
                <div class="flex space-x-4">
                <form action="{{ route('recibos.create', $asociado->matricula) }}" method="GET">
                    @csrf
                    <input type="hidden" name="matricula" value="{{ $asociado->matricula }}">
                    <button class="bg-orange-600 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded-lg shadow flex items-center space-x-2">
                        <span class="transition-transform transform hover:scale-125 hover:text-yellow-300">
                            💰
                        </span>
                        <span>
                            Aportación
                        </span>
                    </button>
                </form>
                <a href="{{ route('recibomatricula', $asociado->matricula) }}"
                   class="inline-block px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-1 transition">
                   📑 Ver Recibos
                </a>
                </div>
              </div>
            </article>
        @endforeach
        </div>

        @if (isset($asociados) && method_exists($asociados, 'currentPage'))
            <p>{{ $asociados->links() }}</p>
        @endif

    </div>
</x-layout>

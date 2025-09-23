

        <div class="mb-2">
            <label for="nombre" class="block text-sm font-medium text-gray-600">Nombre</label>
            <input type="text" 
                   name="nombre" 
                   id="nombre" 
                   placeholder="Nombre"
                   value="{{ old('nombre', $asociado->nombre) }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition" />
            @error('nombre')
                <br />
                <small style="color: red">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-2">
            <label for="apellido" class="block text-sm font-medium text-gray-600">Apellido</label>
            <input type="text" 
                   name="apellido" 
                   placeholder="apellido"
                   value="{{ old('apellido', $asociado->apellido) }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition" />
            @error('apellido')
                <br />
                <small style="color: red">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-2">
            <label class="block text-sm font-medium text-gray-600">
                Sexo:
                    @empty($asociado->sexo)
                        <input type="radio" name="sexo" value="F" checked> Femenino
                    @else
                        <input type="radio" name="sexo" value="F" 
                            {{ old('sexo', $asociado->sexo) === 'F' ? 'checked' : '' }}> Femenino
                    @endempty
                    <input type="radio" name="sexo" value="M" 
                        {{ old('sexo', $asociado->sexo) === 'M' ? 'checked' : '' }}> Masculino
                    @error('sexo')
                        <br />
                        <small style="color: red">{{ $message }}</small>
                    @enderror
                    <br />
            </label>
        </div>


        <div class="mb-2">
            <label for="fecha_nacimiento" class="block text-sm font-medium text-gray-600">Fecha de nacimiento</label>
            <input type="date" 
                   name="fecha_nacimiento" 
                   placeholder="Fecha de nacimiento"
                   value="{{ old('apellido', $asociado->fecha_nacimiento) }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition w-40" />
            @error('fecha_nacimiento')
                <br />
                <small style="color: red">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-2">
            <label class="block text-sm font-medium text-gray-600">
            Puesto:
                @empty($asociado->puesto)
                    <input type="radio" name="puesto" value="J" checked> Jubilado 
                @else
                    <input type="radio" name="puesto" value="J" 
                        {{ old('puesto', $asociado->puesto) === 'J' ? 'checked' : '' }}> Jubilado 
                @endempty
                <input type="radio" name="puesto" value="P" 
                    {{ old('puesto', $asociado->puesto) === 'P' ? 'checked' : '' }}> Pensionado 
                @error('puesto')
                    <br />
                    <small style="color: red">{{ $message }}</small>
                @enderror
            </label>
        </div>



        <div class="mb-2">
            <label for="fecha_jubilacion" class="block text-sm font-medium text-gray-600">{{ 'Fecha de '. ($asociado->puesto === 'P' ? 'pensión:' : 'jubilación:' . ':') }}</label>
            <input type="date" 
                   name="fecha_jubilacion" 
                   placeholder="Fecha de jubilación"
                   value="{{ old('apellido', $asociado->fecha_jubilacion) }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition w-40" />
            @error('fecha_jubilacion')
                <small style="color: red">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-2">
            <label for="celular" class="block text-sm font-medium text-gray-600">Teléfono o Celular</label>
            <input type="tel" 
                   name="celular" 
                   placeholder="Ej. 6671234567" 
                   pattern="[0-9]{10}" 
                   maxlength="10" 
                   value="{{ old('celular', $asociado->celular) }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition w-40" />
            @error('celular')
                <small style="color: red">{{ $message }}</small>
            @enderror
        </div>
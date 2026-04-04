<x-layout meta-title="Resultado de los cambios" meta-description="Resultado de cambios de matricula">


<div class="max-w-3xl mx-auto mt-10 bg-white shadow-lg rounded-lg p-6">

    <h2 class="text-2xl font-bold text-center mb-6">
        Resultado del Cambio de Matrícula
    </h2>

    <div class="mb-6 text-center">

        <p class="text-lg">
            Matrícula anterior:
            <span class="font-bold text-red-600">
                {{ $actual }}
            </span>
        </p>

        <p class="text-lg">
            Matrícula nueva:
            <span class="font-bold text-green-600">
                {{ $nueva }}
            </span>
        </p>

    </div>


    <table class="w-full border border-gray-300">

        <thead class="bg-gray-200">
            <tr>
                <th class="p-3 border">Tabla</th>
                <th class="p-3 border">Registros afectados</th>
            </tr>
        </thead>

        <tbody>

            <tr class="text-center">
                <td class="border p-2">asociados</td>
                <td class="border p-2 font-bold">
                    {{ $resultado['asociados'] }}
                </td>
            </tr>

            <tr class="text-center">
                <td class="border p-2">recibos</td>
                <td class="border p-2 font-bold">
                    {{ $resultado['recibos'] }}
                </td>
            </tr>

            <tr class="text-center">
                <td class="border p-2">asistencias</td>
                <td class="border p-2 font-bold">
                    {{ $resultado['asistencias'] }}
                </td>
            </tr>

        </tbody>

    </table>


    <div class="mt-6 p-4 bg-gray-100 rounded">

        <p class="font-semibold">
            Mensaje del sistema:
        </p>

        <p class="text-blue-700">
            {{ $resultado['mensaje'] }}
        </p>

    </div>


    <div class="mt-8 flex justify-center">

        <a href="{{ route('asociados.index') }}"
           class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">

            Regresar a asociados

        </a>

    </div>

</div>

</x-layout>
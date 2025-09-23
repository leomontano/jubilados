<x-layout meta-title="Cortes" meta-description="Resumen de aportaciones">
<div class="flex justify-center mt-6 space-x-4">
    <a href="{{ route('corte.print') }}" target="_blank" 
       class="px-5 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition">
        🖨 Imprimir Resumen
    </a>
    <a href="{{ route('corte.printDetalle') }}" target="_blank" 
       class="px-5 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
        📑 Imprimir Detalle
    </a>
    <a href="{{ route('asociados.index') }}" 
       class="px-5 py-2 bg-gray-500 text-white rounded-lg shadow hover:bg-gray-600 transition">
        ⬅ Volver
    </a>

</div>





    

</x-layout>

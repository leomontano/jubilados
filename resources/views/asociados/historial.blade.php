<x-layout meta-title="Historial de cambios" meta-description="Historial de cambios de matricula">

<div class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg p-6">


<h2 class="text-2xl font-bold mb-6">
Historial de Cambios de Matrícula
</h2>

<table class="min-w-full bg-white shadow rounded">

<thead class="bg-gray-200">

<tr>

<th class="px-4 py-2">Fecha</th>
<th class="px-4 py-2">Matrícula anterior</th>
<th class="px-4 py-2">Matrícula nueva</th>
<th class="px-4 py-2">Usuario</th>

</tr>

</thead>

<tbody>

@foreach($historial as $h)

<tr class="border-t">

<td class="px-4 py-2">
{{ $h->created_at->format('d/m/Y H:i') }}
</td>

<td class="px-4 py-2 font-semibold text-red-600">
{{ $h->matricula_anterior }}
</td>

<td class="px-4 py-2 font-semibold text-green-600">
{{ $h->matricula_nueva }}
</td>

<td class="px-4 py-2">
{{ $h->usuario_id }}
</td>

</tr>

@endforeach

</tbody>

</table>

<div class="mt-4">
{{ $historial->links() }}
</div>

</div>

</x-layout>
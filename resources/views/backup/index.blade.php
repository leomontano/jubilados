<x-layout meta-title="Cortes" meta-description="Resumen de aportaciones">

<div class="max-w-2xl mx-auto mt-10 p-6 bg-white shadow-xl rounded-xl text-center">
    <h1 class="text-2xl font-bold mb-6">Generar y Subir Respaldo</h1>

    <button id="backupBtn" 
        class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-lg font-semibold">
        Generar y Subir Respaldo
    </button>

    <!-- Loading -->
    <div id="loading" class="hidden mt-4">
        <svg class="animate-spin h-8 w-8 text-blue-600 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
        </svg>
        <p class="mt-2 text-blue-600 font-medium">Procesando respaldo, por favor espera...</p>
    </div>

    <!-- Resultado -->
    <div id="result" class="mt-4 text-lg font-semibold"></div>
</div>

@if(session('success'))
    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
        {{ session('error') }}
    </div>
@endif



<script>
document.getElementById('backupBtn').addEventListener('click', function() {
    let btn = this;
    let loading = document.getElementById('loading');
    let result = document.getElementById('result');

    btn.disabled = true;
    loading.classList.remove('hidden');
    result.innerHTML = "";

    fetch("{{ route('backup.runFTP') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Content-Type": "application/json"
        },
        body: JSON.stringify({})
    })
    .then(res => res.json())
    .then(data => {
        loading.classList.add('hidden');
        btn.disabled = false;
        if (data.success) {
            result.innerHTML = `<span class='text-green-600'>✔ ${data.message}</span>`;
        } else {
            result.innerHTML = `<span class='text-red-600'>✘ ${data.message}</span>`;
        }
    })
    .catch(err => {
        loading.classList.add('hidden');
        btn.disabled = false;
        result.innerHTML = `<span class='text-red-600'>Error: ${err}</span>`;
    });
});
</script>

</x-layout>

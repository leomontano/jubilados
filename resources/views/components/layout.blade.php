<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $metaTitle ?? 'Titulo default'}}</title>
        <meta name="description" content="{{ $metaDescription ?? 'Description default'}}">
        @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>
      <body

    class="flex h-screen flex-col bg-slate-100 selection:bg-sky-600 selection:text-sky-50 dark:bg-slate-950"
  >
        <x-navigation/>
{{--         @session('status')
        <div class="bg-blue-500 p-4 text-xl text-green-50 dark:bg-green-800">
          {{ $value }}
        </div>
 --}}

        @if (session('status'))
            <div id="status-message"
                 class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 shadow-md">
                {{ session('status') }}
            </div>

            <script>
                setTimeout(() => {
                    let msg = document.getElementById('status-message');
                    if (msg) {
                        msg.style.transition = "opacity 0.5s ease";
                        msg.style.opacity = "0";
                        setTimeout(() => msg.remove(), 500);
                    }
                }, 5000); // 5 segundos
            </script>
        @endif

        <main class="flex-1 p-4">
        {{ $slot }}
        </main>

    <footer class="py-10 px-4">
      <div
        class="mx-auto flex max-w-6xl flex-col items-center space-y-4 md:flex-row md:justify-between md:space-y-0"
      >
        <div class="text-center text-sm text-slate-600 dark:text-slate-400">
          ® {{ date("Y") }} {{ session('nombre_asociacion') ?? 'Asociación'  }}. All Rights Reserved
        </div>
        <div class="flex space-x-4">
          <a href="https://www.facebook.com/groups/708511319202614/" target="_blank">
            <svg
              class="w-6 fill-current text-slate-600 duration-300 hover:text-[#1877F2] dark:text-slate-400 dark:hover:text-[#1877F2]"
              role="img"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg"
            >
              <title>Facebook</title>
              <path
                d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"
              />
            </svg>
          </a>

          <a href="#">
            <svg
              class="w-6 fill-current text-slate-600 duration-300 hover:text-[#25D366] dark:text-slate-400 dark:hover:text-[#25D366]"
              role="img"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg"
            >
              <title>WhatsApp</title>
              <path
                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"
              />
            </svg>
          </a>
        </div>
      </div>
    </footer>


    </body>
</html>

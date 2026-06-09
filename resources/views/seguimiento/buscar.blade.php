<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rastrear orden - FixFlow</title>
    <meta name="description" content="Consulta el estado de una reparación en FixFlow usando el folio global de la orden.">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen overflow-x-hidden bg-gradient-to-br from-[#1A0033] via-[#2D004E] to-[#0D0D11] text-gray-900">
    <main class="flex min-h-screen items-center justify-center px-4 py-10 sm:px-6">
        <section class="w-full max-w-lg overflow-hidden rounded-3xl border border-white/10 bg-white shadow-2xl">
            <div class="bg-gradient-to-br from-[#4B0082] to-[#7C3AED] px-6 py-8 text-white sm:px-8">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-white/80 transition hover:text-white">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    FixFlow
                </a>

                <div class="mt-8">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#E0AAFF]">Seguimiento público</p>
                    <h1 class="mt-3 text-3xl font-extrabold leading-tight sm:text-4xl">Rastrea tu orden</h1>
                    <p class="mt-3 text-sm leading-relaxed text-white/80 sm:text-base">
                        Ingresa el folio que te entregó el taller para consultar el avance de tu reparación.
                    </p>
                </div>
            </div>

            <form method="POST" action="{{ route('seguimiento.buscar.submit') }}" class="space-y-5 px-6 py-7 sm:px-8">
                @csrf

                <div>
                    <label for="folio" class="block text-sm font-semibold text-[#2D1B69]">Folio de orden</label>
                    <input
                        id="folio"
                        name="folio"
                        type="text"
                        value="{{ old('folio') }}"
                        placeholder="FF-DEMO-2026-0001"
                        autocomplete="off"
                        autocapitalize="characters"
                        class="mt-2 block min-h-12 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 font-mono text-base font-semibold uppercase tracking-wide text-[#2D1B69] shadow-inner outline-none transition placeholder:text-gray-400 focus:border-[#7C3AED] focus:bg-white focus:ring-4 focus:ring-[#7C3AED]/15"
                    >
                    @error('folio')
                        <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
                    @else
                        <p class="mt-2 text-xs text-gray-500">Ejemplo: FF-DEMO-2026-0001</p>
                    @enderror
                </div>

                <button type="submit" class="inline-flex min-h-12 w-full items-center justify-center gap-2 rounded-2xl bg-[#4B0082] px-5 py-3 text-sm font-bold uppercase tracking-wide text-white shadow-lg shadow-[#4B0082]/20 transition hover:bg-[#5A00C6] focus:outline-none focus:ring-4 focus:ring-[#7C3AED]/25">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m1.1-5.4a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z"></path>
                    </svg>
                    Buscar orden
                </button>

                <p class="text-center text-xs leading-relaxed text-gray-500">
                    Si tu folio no aparece, confirma que el taller ya haya registrado la orden en FixFlow.
                </p>
            </form>
        </section>
    </main>
</body>

</html>

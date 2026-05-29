<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'FixFlow') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Estilo personalizado para el patrón tecnológico (Circuito) --}}
    <style>
        [x-cloak] {
            display: none !important;
        }

        .bg-circuit {
            background-image: url("data:image/svg+xml,%3Csvg width='120' height='120' viewBox='0 0 120 120' xmlns='http://www.w3.org/2000/svg'%3E%3Cg stroke='rgba(255, 255, 255, 0.05)' stroke-width='1.5' fill='none'%3E%3Cpath d='M0 60h30l20 20h40l20-20h10M30 60v30l20 20M70 80v30M90 60v-30l-20-20'/%3E%3Ccircle cx='30' cy='60' r='3' fill='rgba(255, 255, 255, 0.08)' stroke='none'/%3E%3Ccircle cx='50' cy='80' r='3' fill='rgba(255, 255, 255, 0.08)' stroke='none'/%3E%3Ccircle cx='70' cy='80' r='3' fill='rgba(255, 255, 255, 0.08)' stroke='none'/%3E%3Ccircle cx='90' cy='60' r='3' fill='rgba(255, 255, 255, 0.08)' stroke='none'/%3E%3Ccircle cx='50' cy='110' r='3' fill='rgba(255, 255, 255, 0.08)' stroke='none'/%3E%3Ccircle cx='70' cy='10' r='3' fill='rgba(255, 255, 255, 0.08)' stroke='none'/%3E%3C/g%3E%3C/svg%3E");
            background-size: 120px 120px;
        }
    </style>
</head>

<body class="flex min-h-screen flex-col overflow-x-hidden bg-[#f1eded] text-neutral-800">

    {{-- HEADER --}}
    <header class="sticky top-0 z-50 w-full bg-white text-sm shadow-sm">
        @if (Route::has('login'))
        <nav x-data="{ open: false }" @keydown.escape.window="open = false" class="relative w-full border-b border-gray-100 bg-white/95 px-4 py-3 backdrop-blur-sm md:px-6 lg:px-8">
            <div class="flex items-center justify-between gap-4">
            <div class="flex items-center">
                <a href="/" class="text-3xl font-extrabold tracking-tight text-[#4B0082] md:text-4xl">FixFlow</a>
            </div>

            <div class="hidden items-center space-x-10 text-base font-medium text-neutral-600 lg:flex lg:text-lg">
                <a href="#optimiza" class="hover:text-[#4B0082] hover:scale-105 transition-all duration-300">Optimiza tu taller</a>
                <a href="#gestiona" class="hover:text-[#4B0082] hover:scale-105 transition-all duration-300">Gestiona</a>
                <a href="#agilidad" class="hover:text-[#4B0082] hover:scale-105 transition-all duration-300">Agilidad</a>
            </div>

            <div class="hidden items-center space-x-4 md:flex">
                @auth
                <a href="{{ route('panel.inicio') }}" class="px-5 py-2.5 rounded-lg text-white bg-[#4B0082] font-semibold hover:bg-[#5A00C6] transition-colors shadow-md hover:shadow-lg">
                    Centro de Mando
                </a>
                @else
                <a href="{{ route('login') }}" class="px-5 py-2.5 rounded-lg text-white bg-[#4B0082] font-semibold hover:bg-[#5A00C6] transition-colors shadow-md hover:shadow-lg">
                    Iniciar Sesión
                </a>
                @endauth
            </div>

            <button type="button" @click="open = !open" class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-[#4B0082] text-white shadow-sm transition hover:bg-[#5A00C6] md:hidden" aria-label="Abrir menú">
                <svg x-show="!open" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
                <svg x-cloak x-show="open" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            </div>

            <div x-cloak x-show="open" x-transition @click.outside="open = false" class="absolute left-4 right-4 top-full mt-2 rounded-2xl border border-gray-100 bg-white p-3 shadow-xl md:hidden">
                <div class="flex flex-col gap-1">
                    <a href="#optimiza" @click="open = false" class="rounded-xl px-4 py-3 font-medium text-neutral-700 hover:bg-purple-50 hover:text-[#4B0082]">Optimiza tu taller</a>
                    <a href="#gestiona" @click="open = false" class="rounded-xl px-4 py-3 font-medium text-neutral-700 hover:bg-purple-50 hover:text-[#4B0082]">Gestiona</a>
                    <a href="#agilidad" @click="open = false" class="rounded-xl px-4 py-3 font-medium text-neutral-700 hover:bg-purple-50 hover:text-[#4B0082]">Agilidad</a>
                    @auth
                    <a href="{{ route('panel.inicio') }}" class="mt-2 rounded-xl bg-[#4B0082] px-4 py-3 text-center font-semibold text-white shadow-md transition hover:bg-[#5A00C6]">Centro de Mando</a>
                    @else
                    <a href="{{ route('login') }}" class="mt-2 rounded-xl bg-[#4B0082] px-4 py-3 text-center font-semibold text-white shadow-md transition hover:bg-[#5A00C6]">Iniciar Sesión</a>
                    @endauth
                </div>
            </div>
        </nav>
        @endif
    </header>

    {{-- WRAPPER GLOBAL PARA EL TEMA OSCURO --}}
    <div class="relative flex-1 bg-gradient-to-br from-[#2D004E] via-[#4B0082] to-[#1A0033] w-full flex flex-col overflow-hidden">

        {{-- Fondo de circuito global --}}
        <div class="absolute inset-0 bg-circuit opacity-50 pointer-events-none"></div>

        {{-- Resplandores --}}
        <div class="pointer-events-none absolute left-[-10%] top-[-5%] hidden h-[420px] w-[420px] rounded-full bg-[#9D4EDD]/20 blur-[120px] md:block"></div>
        <div class="pointer-events-none absolute right-[-10%] top-[20%] hidden h-[500px] w-[500px] rounded-full bg-[#7B2CBF]/20 blur-[120px] md:block"></div>

        {{-- SECCIÓN PRINCIPAL (HERO) --}}
        <section class="relative z-10 flex w-full items-center px-4 pb-16 pt-10 sm:px-6 lg:px-12 lg:pb-28 lg:pt-16">
            <div class="relative mx-auto flex w-full max-w-[90rem] flex-col items-center justify-between gap-10 lg:flex-row lg:gap-12 xl:gap-20">

                {{-- Columna Izquierda: Información --}}
                <div class="w-full lg:w-[45%] flex flex-col items-center lg:items-start text-center lg:text-left z-10">
                    <div class="mb-6 inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-1.5 text-xs font-semibold uppercase tracking-widest text-[#E0AAFF] shadow-sm backdrop-blur-sm md:mb-8">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse shadow-[0_0_8px_rgba(52,211,153,0.8)]"></span>
                        Plataforma para Talleres
                    </div>

                    <h1 class="mb-5 text-4xl font-extrabold uppercase leading-[1.08] tracking-tight text-white sm:text-5xl lg:mb-6 lg:text-5xl xl:text-6xl">
                        Control Inteligente <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#E0AAFF] to-[#C77DFF]">Para tu Taller</span>
                    </h1>

                    <p class="max-w-2xl text-left text-base leading-relaxed text-white/95 sm:text-lg lg:text-left lg:text-2xl">
                        FixFlow es el sistema integral diseñado para agilizar tus procesos técnicos. Registra equipos, da seguimiento en tiempo real a los estados de cada reparación y mantén el control total de tu flujo de trabajo con profesionalismo.
                    </p>
                </div>

                {{-- Columna Derecha: Centro de Mando --}}
                <div class="relative z-10 mx-auto w-full max-w-lg lg:w-[55%] lg:max-w-none lg:pl-10">
                    <div class="absolute inset-0 bg-[#000000] translate-y-6 blur-2xl opacity-40 rounded-[2rem] -z-10"></div>

                    <div class="group relative overflow-hidden rounded-[1.75rem] border border-white/10 bg-white/5 p-4 shadow-2xl backdrop-blur-xl transition-transform duration-500 hover:scale-[1.02] sm:p-6 lg:rounded-[2.5rem] lg:p-12">
                        {{-- Patrón interior de la tarjeta --}}
                        <div class="absolute inset-0 bg-circuit opacity-40 mix-blend-overlay transition-opacity duration-500 group-hover:opacity-70 pointer-events-none"></div>
                        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-white/30 to-transparent"></div>

                        <div class="relative z-10">
                            <div class="mb-6 flex items-center justify-between sm:mb-8 lg:mb-10">
                                <div class="flex items-center gap-5">
                                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl border border-white/5 bg-white/10 shadow-inner backdrop-blur-md sm:h-14 sm:w-14">
                                        <svg class="h-6 w-6 text-white sm:h-7 sm:w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold tracking-wide text-white sm:text-2xl">Centro de Mando</h3>
                                    </div>
                                </div>
                            </div>

                            {{-- Tarjetas del Centro de Mando --}}
                            <div class="grid grid-cols-2 gap-3 sm:gap-4 lg:gap-6">
                                {{-- Total órdenes --}}
                                <div class="relative overflow-hidden rounded-2xl border border-white/10 bg-gradient-to-br from-[#7B2CBF] to-[#4B0082] p-4 shadow-lg shadow-purple-900/50 transition-transform duration-300 hover:-translate-y-2 sm:p-5 lg:rounded-3xl lg:p-8">
                                    <p class="relative z-10 mb-2 text-sm font-medium text-white/90 lg:text-lg">Total órdenes</p>
                                    <p class="relative z-10 text-4xl font-extrabold text-white sm:text-5xl lg:text-6xl">10</p>
                                </div>

                                {{-- En proceso --}}
                                <div class="relative overflow-hidden rounded-2xl border border-white/5 bg-black/30 p-4 backdrop-blur-md transition-transform duration-300 hover:-translate-y-2 sm:p-5 lg:rounded-3xl lg:p-8">
                                    <p class="relative z-10 mb-2 text-sm font-medium text-white/80 lg:text-lg">En proceso</p>
                                    <p class="relative z-10 text-4xl font-extrabold text-white drop-shadow-[0_0_10px_rgba(199,125,255,0.3)] sm:text-5xl lg:text-6xl">3</p>
                                </div>

                                {{-- Retardos activos --}}
                                <div class="relative overflow-hidden rounded-2xl border border-white/5 bg-black/30 p-4 backdrop-blur-md transition-transform duration-300 hover:-translate-y-2 sm:p-5 lg:rounded-3xl lg:p-8">
                                    <p class="relative z-10 mb-2 text-sm font-medium text-white/80 lg:text-lg">Retardos activos</p>
                                    <p class="relative z-10 text-4xl font-extrabold text-[#FF4D6D] drop-shadow-[0_0_10px_rgba(255,77,109,0.3)] sm:text-5xl lg:text-6xl">0</p>
                                </div>

                                {{-- Entregadas --}}
                                <div class="relative overflow-hidden rounded-2xl border border-white/5 bg-black/30 p-4 backdrop-blur-md transition-transform duration-300 hover:-translate-y-2 sm:p-5 lg:rounded-3xl lg:p-8">
                                    <p class="relative z-10 mb-2 text-sm font-medium text-white/80 lg:text-lg">Entregadas</p>
                                    <p class="relative z-10 text-4xl font-extrabold text-[#34D399] drop-shadow-[0_0_10px_rgba(52,211,153,0.3)] sm:text-5xl lg:text-6xl">7</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        {{-- CONTENEDOR DE SECCIONES INFERIORES --}}
        <main class="relative z-10 mx-auto mb-20 mt-16 w-full max-w-[85rem] space-y-20 px-4 sm:px-6 md:mt-24 md:space-y-28 lg:mb-32 lg:mt-32 lg:space-y-40">

            <div class="text-center">
                <h2 class="mb-5 text-3xl font-extrabold tracking-tight text-white md:mb-6 md:text-5xl">
                    ¿Por qué elegir <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#E0AAFF] to-[#C77DFF]">FixFlow</span>?
                </h2>
                <p class="mx-auto max-w-3xl text-left text-base leading-relaxed text-white/95 sm:text-center md:text-xl lg:text-2xl">
                    Diseñado específicamente para talleres de reparación de electrónica, celulares y cómputo.
                    FixFlow va más allá de un simple registro: es el ecosistema que profesionaliza tu negocio.
                    Olvídate de las notas perdidas y los reclamos por demoras; automatiza el seguimiento, garantiza el cumplimiento de tus tiempos de entrega mediante niveles de servicio (SLA), y bríndale a tus clientes total transparencia en cada reparación.
                </p>
            </div>

            {{-- SECCION OPTIMIZA --}}
            <section id="optimiza" class="flex scroll-mt-28 flex-col items-center justify-between gap-8 lg:flex-row lg:gap-10">
                <div class="w-full space-y-4 text-center lg:w-[30%] lg:text-left">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl border border-[#9D4EDD]/30 bg-[#7B2CBF]/30 shadow-[0_0_15px_rgba(123,44,191,0.5)] md:mx-0 md:h-16 md:w-16">
                        <svg class="w-8 h-8 text-[#E0AAFF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-3xl font-bold tracking-tight text-white md:text-4xl">Optimiza tu Taller</h3>
                    <p class="text-left text-base leading-relaxed text-white/95 sm:text-center md:text-lg lg:text-left lg:text-2xl">
                        Olvídate del papel y Excel. Genera tickets únicos de servicio, asigna técnicos a cada orden y actualiza el progreso de cada equipo en segundos. Todo centralizado para mantener un orden impecable en tu negocio.
                    </p>
                </div>
                {{-- Imagen Optimiza --}}
                <img
                    src="{{ asset('assets/optimiza.webp') }}"
                    alt="Dashboard y listado de órdenes de FixFlow"
                    class="aspect-[16/10] w-full rounded-[1.5rem] object-cover shadow-[0_0_30px_rgba(199,125,255,0.3)] ring-1 ring-[#C77DFF]/40 transition-all duration-500 hover:scale-[1.02] hover:ring-[#E0AAFF]/80 lg:w-[65%] lg:rounded-[2.5rem] lg:shadow-[0_0_40px_rgba(199,125,255,0.4)] lg:hover:shadow-[0_0_60px_rgba(224,170,255,0.6)]"
                >
            </section>

            {{-- SECCION GESTIONA --}}
            <section id="gestiona" class="flex scroll-mt-28 flex-col items-center justify-between gap-8 lg:flex-row-reverse lg:gap-10">
                <div class="w-full space-y-4 text-center lg:w-[30%] lg:text-left">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl border border-[#9D4EDD]/30 bg-[#7B2CBF]/30 shadow-[0_0_15px_rgba(123,44,191,0.5)] md:mx-0 md:h-16 md:w-16">
                        <svg class="w-8 h-8 text-[#E0AAFF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-3xl font-bold tracking-tight text-white md:text-4xl">Gestión y Tiempos SLA</h3>
                    <p class="text-left text-base leading-relaxed text-white/95 sm:text-center md:text-lg lg:text-left lg:text-2xl">
                        Clasifica las reparaciones según nuestra matriz de niveles de servicio (SLA). El sistema calcula automáticamente los tiempos límite de entrega y notifica los retardos, previniendo clientes molestos.
                    </p>
                </div>
                {{-- Imagen Gestiona --}}
                <img
                    src="{{ asset('assets/gestiona.webp') }}"
                    alt="Gestión de tiempos SLA y retardos"
                    class="aspect-[16/10] w-full rounded-[1.5rem] object-cover shadow-[0_0_30px_rgba(199,125,255,0.3)] ring-1 ring-[#C77DFF]/40 transition-all duration-500 hover:scale-[1.02] hover:ring-[#E0AAFF]/80 lg:w-[65%] lg:rounded-[2.5rem] lg:shadow-[0_0_40px_rgba(199,125,255,0.4)] lg:hover:shadow-[0_0_60px_rgba(224,170,255,0.6)]"
                >
            </section>

            {{-- SECCION AGILIDAD --}}
            <section id="agilidad" class="flex scroll-mt-28 flex-col items-center justify-between gap-8 lg:flex-row lg:gap-10">
                <div class="w-full space-y-4 text-center lg:w-[30%] lg:text-left">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl border border-[#9D4EDD]/30 bg-[#7B2CBF]/30 shadow-[0_0_15px_rgba(123,44,191,0.5)] md:mx-0 md:h-16 md:w-16">
                        <svg class="w-8 h-8 text-[#E0AAFF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-3xl font-bold tracking-tight text-white md:text-4xl">Agilidad y Portal Cliente</h3>
                    <p class="text-left text-base leading-relaxed text-white/95 sm:text-center md:text-lg lg:text-left lg:text-2xl">
                        Tus clientes pueden consultar el progreso de su equipo en tiempo real mediante un token único y chatear directamente con los técnicos sin saturar el número de WhatsApp del taller.
                    </p>
                </div>
                {{-- Imagen Agilidad --}}
                <img
                    src="{{ asset('assets/agilidad.webp') }}"
                    alt="Portal de clientes y chat en tiempo real"
                    class="aspect-[16/10] w-full rounded-[1.5rem] object-cover shadow-[0_0_30px_rgba(199,125,255,0.3)] ring-1 ring-[#C77DFF]/40 transition-all duration-500 hover:scale-[1.02] hover:ring-[#E0AAFF]/80 lg:w-[65%] lg:rounded-[2.5rem] lg:shadow-[0_0_40px_rgba(199,125,255,0.4)] lg:hover:shadow-[0_0_60px_rgba(224,170,255,0.6)]"
                >
            </section>

            {{-- CALL TO ACTION FINAL --}}
            <div class="relative overflow-hidden rounded-3xl border border-white/10 bg-gradient-to-r from-[#4B0082]/40 to-[#7B2CBF]/40 p-6 text-center shadow-[0_0_40px_rgba(123,44,191,0.2)] backdrop-blur-xl md:p-12">
                <div class="absolute inset-0 bg-circuit opacity-30 pointer-events-none"></div>
                <h3 class="relative z-10 mb-5 text-3xl font-extrabold text-white md:mb-6 md:text-4xl">Lleva tu negocio al siguiente nivel</h3>
                <p class="relative z-10 mx-auto mb-8 max-w-3xl text-base leading-relaxed text-white/95 md:mb-10 md:text-2xl">
                    Gestiona técnicos, asigna roles, y garantiza que cada equipo sea reparado a tiempo.
                    El historial completo a tu alcance.
                </p>
                <div class="relative z-10 flex justify-center gap-4">
                    <a href="/register" class="w-full rounded-xl bg-gradient-to-r from-[#9D4EDD] to-[#7B2CBF] px-8 py-4 text-center text-base font-bold text-white shadow-[0_0_20px_rgba(157,78,221,0.6)] transition-all hover:-translate-y-1 hover:from-[#C77DFF] hover:to-[#9D4EDD] hover:shadow-[0_0_30px_rgba(199,125,255,0.8)] sm:w-auto sm:text-lg">
                        Crea tu Taller Gratis
                    </a>
                </div>
            </div>
        </main>

        {{-- FOOTER --}}
        <footer class="relative z-10 mt-auto w-full border-t border-white/10 bg-black/10 px-6 py-8 text-center backdrop-blur-sm">
            <p class="text-sm text-white/60">
                &copy; {{ date('Y') }}. Todos los derechos reservados.
            </p>
        </footer>

    </div>
</body>

</html>

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
        .bg-circuit {
            background-image: url("data:image/svg+xml,%3Csvg width='120' height='120' viewBox='0 0 120 120' xmlns='http://www.w3.org/2000/svg'%3E%3Cg stroke='rgba(255, 255, 255, 0.05)' stroke-width='1.5' fill='none'%3E%3Cpath d='M0 60h30l20 20h40l20-20h10M30 60v30l20 20M70 80v30M90 60v-30l-20-20'/%3E%3Ccircle cx='30' cy='60' r='3' fill='rgba(255, 255, 255, 0.08)' stroke='none'/%3E%3Ccircle cx='50' cy='80' r='3' fill='rgba(255, 255, 255, 0.08)' stroke='none'/%3E%3Ccircle cx='70' cy='80' r='3' fill='rgba(255, 255, 255, 0.08)' stroke='none'/%3E%3Ccircle cx='90' cy='60' r='3' fill='rgba(255, 255, 255, 0.08)' stroke='none'/%3E%3Ccircle cx='50' cy='110' r='3' fill='rgba(255, 255, 255, 0.08)' stroke='none'/%3E%3Ccircle cx='70' cy='10' r='3' fill='rgba(255, 255, 255, 0.08)' stroke='none'/%3E%3C/g%3E%3C/svg%3E");
            background-size: 120px 120px;
        }
    </style>
</head>

<body class="bg-[#f1eded] text-neutral-800 flex flex-col min-h-screen">

    {{-- HEADER --}}
    <header class="bg-white w-full  lg:px-8  text-sm sticky top-0 z-50 ">
        @if (Route::has('login'))
        <nav class="sticky top-0 z-50 bg-white/95 backdrop-blur-sm px-6 py-4 flex justify-between items-center w-full shadow-sm border-b border-gray-100">
            <div class="flex items-center">
                <a href="/" class="text-4xl font-extrabold text-[#4B0082] tracking-tight">FixFlow</a>
            </div>

            <div class="hidden md:flex space-x-14 font-medium text-neutral-600 text-lg">
                <a href="#optimiza" class="hover:text-[#4B0082] hover:scale-105 transition-all duration-300">Optimiza tu taller</a>
                <a href="#gestiona" class="hover:text-[#4B0082] hover:scale-105 transition-all duration-300">Gestiona</a>
                <a href="#agilidad" class="hover:text-[#4B0082] hover:scale-105 transition-all duration-300">Agilidad</a>
            </div>

            <div class="hidden md:flex space-x-4">
                <div class="hidden md:flex space-x-4">
                    <a href="/login" class="px-5 py-2.5 rounded-lg text-white bg-[#4B0082] font-semibold hover:bg-[#5A00C6] transition-colors">
                        Iniciar Sesión
                    </a>
                    <a href="/register" class="px-5 py-2.5 rounded-lg text-white bg-[#4B0082] font-semibold hover:bg-[#5A00C6] transition-colors">
                        Registrarse
                    </a>
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
        <div class="absolute top-[-5%] left-[-10%] w-[500px] h-[500px] bg-[#9D4EDD]/20 rounded-full blur-[120px] pointer-events-none"></div>
        <div class="absolute top-[20%] right-[-10%] w-[600px] h-[600px] bg-[#7B2CBF]/20 rounded-full blur-[120px] pointer-events-none"></div>

        {{-- SECCIÓN PRINCIPAL (HERO) --}}
        <section class="relative w-full px-6 lg:px-12 pt-12 pb-20 lg:pt-16 lg:pb-28 flex items-center z-10">
            <div class="relative max-w-[90rem] mx-auto w-full flex flex-col lg:flex-row items-center justify-between gap-16 lg:gap-12 xl:gap-20">

                {{-- Columna Izquierda: Información --}}
                <div class="w-full lg:w-[45%] flex flex-col items-center lg:items-start text-center lg:text-left z-10">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/5 border border-white/10 text-[#E0AAFF] text-xs font-semibold uppercase tracking-widest mb-8 shadow-sm backdrop-blur-sm">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse shadow-[0_0_8px_rgba(52,211,153,0.8)]"></span>
                        Plataforma para Talleres
                    </div>

                    <h1 class="text-4xl lg:text-5xl xl:text-6xl font-extrabold text-white mb-6 leading-[1.1] uppercase tracking-tight">
                        Control Inteligente <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#E0AAFF] to-[#C77DFF]">Para tu Taller</span>
                    </h1>

                    <p class="text-lg lg:text-xl text-white/80 leading-relaxed text-justify lg:text-left max-w-2xl">
                        FixFlow es el sistema integral diseñado para agilizar tus procesos técnicos. Registra equipos, da seguimiento en tiempo real a los estados de cada reparación y mantén el control total de tu flujo de trabajo con profesionalismo.
                    </p>

                    <div class="mt-10 flex items-center gap-4">
                        <div class="flex -space-x-3">
                        </div>
                    </div>
                </div>

                {{-- Columna Derecha: Centro de Mando --}}
                <div class="relative w-full lg:w-[55%] max-w-lg lg:max-w-none mx-auto z-10 lg:pl-10">
                    <div class="absolute inset-0 bg-[#000000] translate-y-6 blur-2xl opacity-40 rounded-[2rem] -z-10"></div>

                    <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-[2.5rem] p-8 lg:p-12 shadow-2xl relative overflow-hidden group transform transition-transform hover:scale-[1.02] duration-500">
                        {{-- Patrón interior de la tarjeta --}}
                        <div class="absolute inset-0 bg-circuit opacity-40 mix-blend-overlay transition-opacity duration-500 group-hover:opacity-70 pointer-events-none"></div>
                        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-white/30 to-transparent"></div>

                        <div class="relative z-10">
                            <div class="flex justify-between items-center mb-10">
                                <div class="flex items-center gap-5">
                                    <div class="w-14 h-14 rounded-2xl bg-white/10 flex items-center justify-center shadow-inner border border-white/5 backdrop-blur-md">
                                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-white font-bold text-2xl tracking-wide">Centro de Mando</h3>
                                    </div>
                                </div>
                            </div>

                            {{-- Tarjetas del Centro de Mando --}}
                            <div class="grid grid-cols-2 gap-6">
                                {{-- Total órdenes --}}
                                <div class="bg-gradient-to-br from-[#7B2CBF] to-[#4B0082] rounded-3xl p-6 lg:p-8 border border-white/10 transition-transform hover:-translate-y-2 duration-300 relative overflow-hidden shadow-lg shadow-purple-900/50">
                                    <p class="text-white/90 text-base lg:text-lg font-medium mb-2 relative z-10">Total órdenes</p>
                                    <p class="text-6xl font-extrabold text-white relative z-10">10</p>
                                </div>

                                {{-- En proceso --}}
                                <div class="bg-black/30 backdrop-blur-md rounded-3xl p-6 lg:p-8 border border-white/5 transition-transform hover:-translate-y-2 duration-300 relative overflow-hidden">
                                    <p class="text-white/80 text-base lg:text-lg font-medium mb-2 relative z-10">En proceso</p>
                                    <p class="text-6xl font-extrabold text-white drop-shadow-[0_0_10px_rgba(199,125,255,0.3)] relative z-10">3</p>
                                </div>

                                {{-- Retardos activos --}}
                                <div class="bg-black/30 backdrop-blur-md rounded-3xl p-6 lg:p-8 border border-white/5 transition-transform hover:-translate-y-2 duration-300 relative overflow-hidden">
                                    <p class="text-white/80 text-base lg:text-lg font-medium mb-2 relative z-10">Retardos activos</p>
                                    <p class="text-6xl font-extrabold text-[#FF4D6D] drop-shadow-[0_0_10px_rgba(255,77,109,0.3)] relative z-10">0</p>
                                </div>

                                {{-- Entregadas --}}
                                <div class="bg-black/30 backdrop-blur-md rounded-3xl p-6 lg:p-8 border border-white/5 transition-transform hover:-translate-y-2 duration-300 relative overflow-hidden">
                                    <p class="text-white/80 text-base lg:text-lg font-medium mb-2 relative z-10">Entregadas</p>
                                    <p class="text-6xl font-extrabold text-[#34D399] drop-shadow-[0_0_10px_rgba(52,211,153,0.3)] relative z-10">7</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        {{-- CONTENEDOR DE SECCIONES INFERIORES --}}
        <main class="w-full max-w-6xl mx-auto px-6 mt-32 mb-32 z-10 relative space-y-40">
            
            <div class="text-center">
                <h2 class="text-3xl md:text-5xl font-extrabold text-white tracking-tight mb-6">
                    ¿Por qué elegir <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#E0AAFF] to-[#C77DFF]">FixFlow</span>?
                </h2>
                <p class="text-lg md:text-xl text-white/70 max-w-3xl mx-auto leading-relaxed">
                    Diseñado específicamente para talleres de reparación de electrónica, celulares y cómputo.
                    FixFlow va más allá de un simple registro: es el ecosistema que profesionaliza tu negocio. 
                    Olvídate de las notas perdidas y los reclamos por demoras; automatiza el seguimiento, garantiza el cumplimiento de tus tiempos de entrega mediante niveles de servicio (SLA), y bríndale a tus clientes total transparencia en cada reparación.
                </p>
            </div>

            {{-- SECCION OPTIMIZA --}}
            <section id="optimiza" class="scroll-mt-40 flex flex-col md:flex-row items-center gap-12 lg:gap-20">
                <div class="flex-1 space-y-6 text-center md:text-left">
                    <div class="w-16 h-16 rounded-2xl bg-[#7B2CBF]/30 border border-[#9D4EDD]/30 flex items-center justify-center mx-auto md:mx-0 shadow-[0_0_15px_rgba(123,44,191,0.5)]">
                        <svg class="w-8 h-8 text-[#E0AAFF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-3xl md:text-4xl font-bold text-white tracking-tight">Optimiza tu Taller</h3>
                    <p class="text-white/70 leading-relaxed text-lg">
                        Olvídate del papel y Excel. Genera tickets únicos de servicio, asigna técnicos a cada orden y actualiza el progreso de cada equipo en segundos. Todo centralizado para mantener un orden impecable en tu negocio.
                    </p>
                </div>
                {{-- Placeholder Imagen --}}
                <div class="flex-1 w-full aspect-video md:aspect-[4/3] bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-md rounded-3xl border border-white/10 flex items-center justify-center relative overflow-hidden group shadow-2xl">
                    <div class="absolute inset-0 bg-circuit opacity-30 mix-blend-overlay"></div>
                    <div class="text-white/40 text-center relative z-10 group-hover:scale-105 transition-transform duration-500">
                        <svg class="w-16 h-16 mx-auto mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p class="font-medium text-lg">Espacio para captura de pantalla</p>
                        <p class="text-sm">Ej: Dashboard principal o Listado de Órdenes</p>
                    </div>
                </div>
            </section>

            {{-- SECCION GESTIONA --}}
            <section id="gestiona" class="scroll-mt-40 flex flex-col md:flex-row-reverse items-center gap-12 lg:gap-20">
                <div class="flex-1 space-y-6 text-center md:text-left">
                    <div class="w-16 h-16 rounded-2xl bg-[#7B2CBF]/30 border border-[#9D4EDD]/30 flex items-center justify-center mx-auto md:mx-0 shadow-[0_0_15px_rgba(123,44,191,0.5)]">
                        <svg class="w-8 h-8 text-[#E0AAFF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-3xl md:text-4xl font-bold text-white tracking-tight">Gestión y Tiempos SLA</h3>
                    <p class="text-white/70 leading-relaxed text-lg">
                        Clasifica las reparaciones según nuestra matriz de niveles de servicio (SLA). El sistema calcula automáticamente los tiempos límite de entrega y notifica los retardos, previniendo clientes molestos.
                    </p>
                </div>
                {{-- Placeholder Imagen --}}
                <div class="flex-1 w-full aspect-video md:aspect-[4/3] bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-md rounded-3xl border border-white/10 flex items-center justify-center relative overflow-hidden group shadow-2xl">
                    <div class="absolute inset-0 bg-circuit opacity-30 mix-blend-overlay"></div>
                    <div class="text-white/40 text-center relative z-10 group-hover:scale-105 transition-transform duration-500">
                        <svg class="w-16 h-16 mx-auto mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p class="font-medium text-lg">Espacio para captura de pantalla</p>
                        <p class="text-sm">Ej: Detalle de reparación o Badges de Retardo</p>
                    </div>
                </div>
            </section>

            {{-- SECCION AGILIDAD --}}
            <section id="agilidad" class="scroll-mt-40 flex flex-col md:flex-row items-center gap-12 lg:gap-20">
                <div class="flex-1 space-y-6 text-center md:text-left">
                    <div class="w-16 h-16 rounded-2xl bg-[#7B2CBF]/30 border border-[#9D4EDD]/30 flex items-center justify-center mx-auto md:mx-0 shadow-[0_0_15px_rgba(123,44,191,0.5)]">
                        <svg class="w-8 h-8 text-[#E0AAFF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-3xl md:text-4xl font-bold text-white tracking-tight">Agilidad y Portal Cliente</h3>
                    <p class="text-white/70 leading-relaxed text-lg">
                        Tus clientes pueden consultar el progreso de su equipo en tiempo real mediante un token único y chatear directamente con los técnicos sin saturar el número de WhatsApp del taller.
                    </p>
                </div>
                {{-- Placeholder Imagen --}}
                <div class="flex-1 w-full aspect-video md:aspect-[4/3] bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-md rounded-3xl border border-white/10 flex items-center justify-center relative overflow-hidden group shadow-2xl">
                    <div class="absolute inset-0 bg-circuit opacity-30 mix-blend-overlay"></div>
                    <div class="text-white/40 text-center relative z-10 group-hover:scale-105 transition-transform duration-500">
                        <svg class="w-16 h-16 mx-auto mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p class="font-medium text-lg">Espacio para captura de pantalla</p>
                        <p class="text-sm">Ej: Vista del Portal de Seguimiento</p>
                    </div>
                </div>
            </section>
            
            {{-- CALL TO ACTION FINAL --}}
            <div class="bg-gradient-to-r from-[#4B0082]/40 to-[#7B2CBF]/40 backdrop-blur-xl border border-white/10 rounded-3xl p-8 md:p-12 text-center relative overflow-hidden shadow-[0_0_40px_rgba(123,44,191,0.2)]">
                <div class="absolute inset-0 bg-circuit opacity-30 pointer-events-none"></div>
                <h3 class="text-3xl md:text-4xl font-extrabold text-white mb-6 relative z-10">Lleva tu negocio al siguiente nivel</h3>
                <p class="text-lg md:text-xl text-white/80 mb-10 max-w-3xl mx-auto relative z-10 leading-relaxed">
                    Gestiona técnicos, asigna roles, y garantiza que cada equipo sea reparado a tiempo. 
                    El historial completo a tu alcance.
                </p>
                <div class="flex justify-center gap-4 relative z-10">
                    <a href="/register" class="px-8 py-4 rounded-xl text-white bg-gradient-to-r from-[#9D4EDD] to-[#7B2CBF] font-bold text-lg hover:from-[#C77DFF] hover:to-[#9D4EDD] transition-all shadow-[0_0_20px_rgba(157,78,221,0.6)] hover:shadow-[0_0_30px_rgba(199,125,255,0.8)] transform hover:-translate-y-1">
                        Crea tu Taller Gratis
                    </a>
                </div>
            </div>
        </main>

        {{-- FOOTER --}}
        <footer class="relative z-10 w-full px-6 py-8 text-center border-t border-white/10 mt-auto backdrop-blur-sm bg-black/10">
            <p class="text-sm text-white/60">
                &copy; {{ date('Y') }}. Todos los derechos reservados.
            </p>
        </footer>

    </div>
</body>

</html>
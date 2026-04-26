<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FixFlow — @yield('titulo-pestana')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-slate-50 to-gray-100 antialiased">

    <div id="contenedor-principal" class="flex min-h-screen">

        {{-- Barra lateral --}}
        <aside id="sidebar" class=" sticky top-0 h-screen  flex-shrink-0 overflow-y-auto w-72 bg-[#1E055A] text-white flex flex-col shadow-2xl">
            <div class="p-6 border-b border-indigo-800/50">
                <h1 class="text-2xl font-bold tracking-tight bg-gradient-to-r from-white to-indigo-200 bg-clip-text text-transparent">FixFlow</h1>
                <p class="text-indigo-300 text-sm mt-1 font-medium">{{ auth()->user()->taller->nombre }}</p>
            </div>
            <nav aria-label="Navegación principal" class="flex-1 p-4">
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('panel.inicio') }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 font-medium
                           {{ request()->routeIs('panel.inicio') ? 'bg-white/20 shadow-lg' : 'hover:bg-indigo-700/50' }}">
                            <span class="w-5 h-5"><svg viewBox="-4.8 -4.8 33.60 33.60" xmlns="http://www.w3.org/2000/svg" fill="#fdf7f7">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <title></title>
                                        <g id="Complete">
                                            <g id="grid">
                                                <g>
                                                    <rect fill="none" height="7" stroke="#ffffff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" width="7" x="14.5" y="2.5"></rect>
                                                    <rect fill="none" height="7" stroke="#ffffff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" width="7" x="14.5" y="14.5"></rect>
                                                    <rect fill="none" height="7" stroke="#ffffff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" width="7" x="2.5" y="2.5"></rect>
                                                    <rect fill="none" height="7" stroke="#ffffff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" width="7" x="2.5" y="14.5"></rect>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </svg></span> Centro de Mando
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('reparaciones.index') }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200
                           {{ request()->routeIs('reparaciones.index') ? 'bg-white/20 shadow-lg' : 'hover:bg-indigo-700/50' }}">
                            <span class="w-5 h-5"><svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path d="M9 5H7C5.89543 5 5 5.89543 5 7V19C5 20.1046 5.89543 21 7 21H17C18.1046 21 19 20.1046 19 19V7C19 5.89543 18.1046 5 17 5H15" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M12 12H15" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M12 16H15" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                        <circle cx="9" cy="12" r="1" fill="#ffffff"></circle>
                                        <circle cx="9" cy="16" r="1" fill="#ffffff"></circle>
                                    </g>
                                </svg></span> Órdenes
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('reparaciones.create') }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200
                           {{ request()->routeIs('reparaciones.create') ? 'bg-white/20 shadow-lg' : 'hover:bg-indigo-700/50' }}">
                            <span class="w-5 h-5"><svg viewBox="-2 -2 24.00 24.00" xmlns="http://www.w3.org/2000/svg" fill="none">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path fill="#ffffff" fill-rule="evenodd" d="M9 17a1 1 0 102 0v-6h6a1 1 0 100-2h-6V3a1 1 0 10-2 0v6H3a1 1 0 000 2h6v6z"></path>
                                    </g>
                                </svg></span> Nueva Orden
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('clientes.index') }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200
                           {{ request()->routeIs('clientes.index') ? 'bg-white/20 shadow-lg' : 'hover:bg-indigo-700/50' }}">
                            <span class="w-6 h-6"><svg fill="#ffffff" viewBox="0 0 1024.00 1024.00" xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <circle cx="435.2" cy="409.5" r="102.4"></circle>
                                        <path d="M588.8 409.5c0 17.6-3.1 34.5-8.6 50.3 2.9.2 5.7.9 8.6.9 56.6 0 102.4-45.8 102.4-102.4 0-56.6-45.8-102.4-102.4-102.4-26.1 0-49.7 10.1-67.8 26.2 40.9 27.7 67.8 74.4 67.8 127.4zM435.2 563.1c-128 0-179.2 25.6-179.2 102.4v102.6h358.4V665.5c0-77.3-51.2-102.4-179.2-102.4z"></path>
                                        <path d="M588.8 511.9c-14.5 0-27.9.4-40.5 1.1-2.3 2.5-4.6 4.9-7 7.2 63.7 13.5 124.2 49.5 124.2 145.3v51.4H768V614.3c0-77.3-51.2-102.4-179.2-102.4z"></path>
                                    </g>
                                </svg></span> Clientes
                        </a>
                    </li>
                    @if(auth()->user()->esAdmin())
                    <li>
                        <a href="{{ route('tecnicos.index') }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200
                               {{ request()->routeIs('tecnicos.index') ? 'bg-white/20 shadow-lg' : 'hover:bg-indigo-700/50' }}">
                            <span class="w-5 h-5"><svg version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="-102.4 -102.4 716.80 716.80" xml:space="preserve" fill="#ffffff" stroke="#ffffff">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <style type="text/css">
                                            .st0 {
                                                fill: #ffffff;
                                            }
                                        </style>
                                        <g>
                                            <path class="st0" d="M459.957,203.4c42.547-38.609,49.656-82.484,40.141-119.469c-0.281-2.938-0.984-5.406-3.547-7.266 l-8.563-7.016c-1.484-1.375-3.484-2.063-5.484-1.859c-2.016,0.188-3.844,1.234-5.031,2.859l-49.25,64.031 c-1.375,1.891-3.594,2.969-5.922,2.891l-17.875,1.313c-1.531-0.047-3.016-0.594-4.219-1.563l-34.531-29.266 c-1.406-1.141-2.328-2.766-2.563-4.563l-2.141-16.188c-0.25-1.781,0.203-3.594,1.266-5.047l46.109-62.641 c2.094-2.891,1.688-6.875-0.906-9.297l-11.188-8.734c-2.188-2.047-4.672-1.75-8.063-1.109 c-31.844,6.297-86.219,37.125-100.016,79.75c-12.156,37.516-7.922,63.969-7.922,63.969c0,21.141-6.953,41.516-15.5,50.078 L24.504,424.916c-0.469,0.438-0.922,0.859-1.375,1.313c-19.844,19.844-19.813,52.063-0.641,71.219 c19.172,19.172,51.859,19.688,71.703-0.172c0.922-0.922,1.813-1.875,2.641-2.859l231.672-250.438 C357.004,218.619,413.426,245.65,459.957,203.4z"></path>
                                        </g>
                                    </g>
                                </svg></span> Técnicos
                        </a>
                    </li>
                    @endif
                </ul>
            </nav>
            <footer class="p-5 border-t border-indigo-800/50 space-y-3">
                <div class="flex items-center justify-between text-sm">
                    <span class="font-medium text-indigo-200">{{ auth()->user()->name }}</span>
                    <span class="bg-indigo-800/60 px-2 py-0.5 rounded-full text-xs text-indigo-200">{{ auth()->user()->rol }}</span>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2 rounded-lg bg-[#8C0053] hover:bg-[#640039] text-red-200 transition-all duration-200 font-medium text-sm">
                        <span class="w-5 h-5"> <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#FF82B8">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="0.048"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <g id="Interface / Log_Out">
                                        <path id="Vector" d="M12 15L15 12M15 12L12 9M15 12H4M9 7.24859V7.2002C9 6.08009 9 5.51962 9.21799 5.0918C9.40973 4.71547 9.71547 4.40973 10.0918 4.21799C10.5196 4 11.0801 4 12.2002 4H16.8002C17.9203 4 18.4796 4 18.9074 4.21799C19.2837 4.40973 19.5905 4.71547 19.7822 5.0918C20 5.5192 20 6.07899 20 7.19691V16.8036C20 17.9215 20 18.4805 19.7822 18.9079C19.5905 19.2842 19.2837 19.5905 18.9074 19.7822C18.48 20 17.921 20 16.8031 20H12.1969C11.079 20 10.5192 20 10.0918 19.7822C9.71547 19.5905 9.40973 19.2839 9.21799 18.9076C9 18.4798 9 17.9201 9 16.8V16.75" stroke="#FF82B8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </g>
                                </g>
                            </svg></span> Cerrar sesión
                    </button>
                </form>
            </footer>
        </aside>

        {{-- Contenido principal --}}
        <div id="contenedor-derecho" class="flex-1 flex flex-col">

            <header id="header-principal" class="bg-white/80 backdrop-blur-sm shadow-sm border-b border-gray-200 px-8 py-4 flex justify-between items-center sticky top-0 z-10">
                <span class="text-xl font-bold text-[#1E055A] tracking-tight">@yield('titulo-pestana')</span>

                {{-- Badge de notificaciones (solo admin) --}}
                @if(auth()->user()->esAdmin())
                @php $countNotif = auth()->user()->unreadNotifications->count(); @endphp
                @if($countNotif > 0)
                <a href="#" aria-label="{{ $countNotif }} notificaciones no leídas" class="flex items-center gap-2 bg-amber-50 hover:bg-amber-100 text-amber-700 px-4 py-2 rounded-full transition-all duration-200 font-medium text-sm shadow-sm">
                    <span>🔔</span> {{ $countNotif }} alerta(s)
                </a>
                @endif
                @endif
            </header>

            <main id="contenido-principal" class="flex-1 p-8">
                @yield('contenido-principal')
            </main>

        </div>
    </div>

    @stack('scripts')
</body>

</html>
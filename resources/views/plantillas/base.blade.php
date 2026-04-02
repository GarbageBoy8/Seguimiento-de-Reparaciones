<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FixFlow — @yield('titulo-pestana')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    <div id="contenedor-principal">

        {{-- Barra lateral --}}
        <aside id="sidebar">
            <div>
                <h1>FixFlow</h1>
                <p>{{ auth()->user()->taller->nombre }}</p>
            </div>
            <nav aria-label="Navegación principal">
                <ul>
                    <li><a href="{{ route('panel.inicio') }}">Centro de Mando</a></li>
                    <li><a href="{{ route('reparaciones.index') }}">Órdenes</a></li>
                    <li><a href="{{ route('reparaciones.create') }}">+ Nueva Orden</a></li>
                    <li><a href="{{ route('clientes.index') }}">Clientes</a></li>
                </ul>
            </nav>
            <footer>
                <span>{{ auth()->user()->name }}</span>
                <span>({{ auth()->user()->rol }})</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">Cerrar sesión</button>
                </form>
            </footer>
        </aside>

        {{-- Contenido principal --}}
        <div id="contenedor-derecho">

            <header id="header-principal">
                <span>@yield('titulo-pestana')</span>

                {{-- Badge de notificaciones (solo admin) --}}
                @if(auth()->user()->esAdmin())
                    @php $countNotif = auth()->user()->unreadNotifications->count(); @endphp
                    @if($countNotif > 0)
                        <a href="#" aria-label="{{ $countNotif }} notificaciones no leídas">
                            🔔 {{ $countNotif }} alerta(s)
                        </a>
                    @endif
                @endif
            </header>

            <main id="contenido-principal">
                @yield('contenido-principal')
            </main>

        </div>
    </div>

</body>
</html>
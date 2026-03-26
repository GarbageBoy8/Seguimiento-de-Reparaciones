<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TOBILLOS - @yield('titulo-pestana')</title>
    
    <style>
        /* 1. Reseteo y fondo general */
        body, html { margin: 0; padding: 0; font-family: system-ui, sans-serif; background-color: #f8fafc; color: #333; }

        /* 2. Dividimos la pantalla en 2 (Izquierda y Derecha) con Flexbox */
        .contenedor-principal { display: flex; height: 100vh; overflow: hidden; }

        /* 3. BARRA LATERAL (Oscura) */
        .sidebar { width: 260px; background-color: #0f172a; color: white; padding: 24px; display: flex; flex-direction: column; }
        .sidebar h1 { font-size: 1.25rem; margin-bottom: 0; color: white; }
        .sidebar p { font-size: 0.8rem; color: #94a3b8; margin-top: 4px; margin-bottom: 32px;}
        .sidebar ul { list-style: none; padding: 0; margin: 0; }
        .sidebar li { margin-bottom: 8px; }
        .sidebar a { color: #cbd5e1; text-decoration: none; display: block; padding: 12px 16px; border-radius: 8px; font-size: 0.95rem; transition: background 0.2s;}
        .sidebar a:hover { background-color: rgba(255,255,255,0.05); }
        .sidebar a.activo { background-color: rgba(255,255,255,0.1); color: white; font-weight: 500; }

        /* 4. CONTENEDOR DERECHO */
        .contenedor-derecho { flex: 1; display: flex; flex-direction: column; overflow-y: auto; }

        /* 5. BARRA SUPERIOR (Blanca) */
        .header-principal { background-color: white; padding: 16px 32px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e2e8f0; }
        .header-principal input { padding: 10px 16px; border-radius: 999px; border: 1px solid #e2e8f0; width: 320px; outline: none; background-color: #f8fafc; }
        .acciones-usuario { display: flex; gap: 20px; align-items: center; font-size: 0.9rem; }
        .acciones-usuario button { cursor: pointer; border: none; background: transparent; }
        .btn-nueva-orden { background-color: #2563eb !important; color: white !important; padding: 8px 16px !important; border-radius: 8px; font-weight: 500; }

        /* 6. ZONA DE CONTENIDO CENTRAL */
        main { padding: 32px; }

        /* 7. GRID PARA TARJETAS DE ARRIBA (Estadísticas en 3 columnas) */
        .estadisticas { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; margin-bottom: 40px; }
        .estadisticas article { background: white; padding: 24px; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .estadisticas h3 { margin: 0 0 4px 0; font-size: 2rem; color: #0f172a; }
        .estadisticas p { margin: 0; color: #64748b; font-size: 0.9rem; font-weight: 500; }

        /* 8. GRID PARA TARJETAS DE ABAJO (Órdenes en 3 columnas) */
        .ordenes-en-proceso h2 { font-size: 1.25rem; color: #0f172a; margin-bottom: 20px; }
        .grid-ordenes { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }
        .grid-ordenes article { background: white; padding: 24px; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .grid-ordenes header { display: flex; justify-content: space-between; font-size: 0.75rem; font-weight: 600; margin-bottom: 16px; }
        .grid-ordenes header strong { color: #64748b; }
        .grid-ordenes header span { background-color: #eff6ff; color: #2563eb; padding: 4px 10px; border-radius: 999px; }
        .grid-ordenes h4 { margin: 0 0 4px 0; font-size: 1.1rem; color: #0f172a; }
        .grid-ordenes p { font-size: 0.9rem; color: #475569; margin: 4px 0; }
        .grid-ordenes footer { margin-top: 20px; padding-top: 16px; border-top: 1px solid #f1f5f9; display: flex; justify-content: space-between; font-size: 0.85rem; align-items: center; }
        .grid-ordenes footer small { color: #64748b; }
        .grid-ordenes footer a { color: #2563eb; text-decoration: none; font-weight: 500; }
    </style>
</head>
<body>
    
    <div class="contenedor-principal">

        <aside class="sidebar">
            <div>
                <h1>TOBILLOS</h1>
                <p>Centro de reparación</p>
            </div>
            <nav>
                <ul>
                    <li><a href="{{ route('panel.inicio') }}" class="activo">Centro de Mando</a></li>
                    <li><a href="#">Órdenes concluidas</a></li>
                </ul>
            </nav>
        </aside>

        <div class="contenedor-derecho">
            
            <header class="header-principal">
                <input type="search" placeholder="Buscar órdenes, clientes...">
                <div class="acciones-usuario">
                    <button>Notificaciones (1)</button>
                    <button class="btn-nueva-orden">+ Nueva orden</button>
                    <span>Usuario: Admin</span>
                </div>
            </header>

            <main>
                @yield('contenido-principal')
            </main>
        </div>
    </div>

</body>
</html>
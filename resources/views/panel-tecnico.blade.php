@extends('plantillas.base')

@section('titulo-pestana', 'Centro de Mando')

@section('contenido-principal')

    <section class="estadisticas">
        <article>
            <h3>6</h3>
            <p>Total órdenes</p>
        </article>
        <article>
            <h3>4</h3>
            <p>En proceso</p>
        </article>
        <article>
            <h3>2</h3>
            <p>Completadas</p>
        </article>
    </section>

    <section class="ordenes-en-proceso">
        <h2>Órdenes en proceso</h2>
        
        <div class="grid-ordenes">
            <article>
                <header>
                    <strong>ORD-001</strong> <span>En reparación</span>
                </header>
                <div>
                    <h4>María González</h4>
                    <p>Celular · Samsung Galaxy S23</p>
                    <p>Pantalla rota, no responde al tacto en la parte inferior</p>
                </div>
                <footer>
                    <small>Ingreso: 2026-03-20</small>
                    <a href="#">Ver detalles</a>
                </footer>
            </article>

            <article>
                <header>
                    <strong>ORD-002</strong> <span style="background-color: #fef2f2; color: #dc2626;">Esperando piezas</span>
                </header>
                <div>
                    <h4>Carlos Ramírez</h4>
                    <p>Laptop · HP Pavilion 15</p>
                    <p>No enciende, posible falla en fuente de poder</p>
                </div>
                <footer>
                    <small>Ingreso: 2026-03-19</small>
                    <a href="#">Ver detalles</a>
                </footer>
            </article>
            
            <article>
                <header>
                    <strong>ORD-003</strong> <span style="background-color: #fefce8; color: #ca8a04;">En revisión</span>
                </header>
                <div>
                    <h4>Ana López</h4>
                    <p>Celular · iPhone 14 Pro Max</p>
                    <p>Batería se descarga muy rápido, posible reemplazo</p>
                </div>
                <footer>
                    <small>Ingreso: 2026-03-22</small>
                    <a href="#">Ver detalles</a>
                </footer>
            </article>
        </div>
    </section>

@endsection
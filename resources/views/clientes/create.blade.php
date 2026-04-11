@extends('plantillas.base')

@section('titulo-pestana', 'Nuevo Cliente')

@section('contenido-principal')

    <h1>Registrar nuevo cliente</h1>

    @if($errors->any())
        <ul role="alert">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('clientes.store') }}">
        @csrf

        <div>
            <label for="nombre">Nombre completo <span aria-hidden="true">*</span></label>
            <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required autofocus />
        </div>

        <div>
            <label for="telefono">Teléfono</label>
            <input type="text" id="telefono" name="telefono" value="{{ old('telefono') }}" />
        </div>

        <div>
            <label for="email">Email (para notificaciones de equipo listo)</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" />
        </div>

        <div>
            <label for="direccion">Dirección</label>
            <textarea id="direccion" name="direccion" rows="2">{{ old('direccion') }}</textarea>
        </div>

        <button type="submit">Guardar cliente</button>
        <a href="{{ route('clientes.index') }}">Cancelar</a>
    </form>

@endsection

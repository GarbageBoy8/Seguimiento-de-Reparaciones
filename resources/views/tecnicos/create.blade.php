@extends('plantillas.base')

@section('titulo-pestana', 'Nuevo Técnico')

@section('contenido-principal')

    <h1>Agregar técnico al taller</h1>

    @if($errors->any())
        <ul role="alert">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('tecnicos.store') }}">
        @csrf

        <div>
            <label for="name">Nombre completo <span aria-hidden="true">*</span></label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus />
        </div>

        <div>
            <label for="email">Email (para inicio de sesión) <span aria-hidden="true">*</span></label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required />
        </div>

        <div>
            <label for="password">Contraseña <span aria-hidden="true">*</span></label>
            <input type="password" id="password" name="password" required />
        </div>

        <div>
            <label for="password_confirmation">Confirmar contraseña <span aria-hidden="true">*</span></label>
            <input type="password" id="password_confirmation" name="password_confirmation" required />
        </div>

        <p><small>El técnico podrá iniciar sesión con este email y contraseña en el mismo panel.</small></p>

        <button type="submit">Crear técnico</button>
        <a href="{{ route('tecnicos.index') }}">Cancelar</a>
    </form>

@endsection

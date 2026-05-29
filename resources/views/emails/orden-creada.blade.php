<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recibimos tu equipo — {{ $reparacion->folio }}</title>
</head>
<body>
    <h1>¡Recibimos tu equipo!</h1>
    <p>Hola, <strong>{{ $reparacion->cliente->nombre }}</strong>. Tu equipo ingresó correctamente a nuestro taller y ya estamos trabajando en él.</p>

    <dl>
        <dt>Folio</dt>
        <dd>{{ $reparacion->folio }}</dd>

        <dt>Equipo</dt>
        <dd>{{ $reparacion->tipo_equipo }} — {{ $reparacion->marca }} {{ $reparacion->modelo }}</dd>

        <dt>Problema reportado</dt>
        <dd>{{ $reparacion->problema_reportado }}</dd>

        <dt>Taller</dt>
        <dd>{{ $reparacion->taller->nombre }}</dd>
    </dl>

    <p>
        Puedes seguir el estado de tu reparación en tiempo real desde el siguiente enlace:
        <br>
        <a href="{{ $urlSeguimiento }}">{{ $urlSeguimiento }}</a>
    </p>

    <p><small>Este mensaje fue generado automáticamente por FixFlow. Por favor no respondas a este correo.</small></p>
</body>
</html>

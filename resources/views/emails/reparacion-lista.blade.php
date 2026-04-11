<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tu equipo está listo — {{ $reparacion->folio }}</title>
</head>
<body>
    <h1>¡Tu equipo está listo para recoger!</h1>
    <p>Hola, te informamos que la reparación de tu equipo ha sido completada.</p>

    <dl>
        <dt>Folio</dt>
        <dd>{{ $reparacion->folio }}</dd>

        <dt>Equipo</dt>
        <dd>{{ $reparacion->tipo_equipo }} — {{ $reparacion->marca }} {{ $reparacion->modelo }}</dd>

        <dt>Taller</dt>
        <dd>{{ $reparacion->taller->nombre }}</dd>
    </dl>

    <p>
        Puedes ver el estado actualizado de tu orden en el siguiente enlace:
        <a href="{{ $urlSeguimiento }}">{{ $urlSeguimiento }}</a>
    </p>

    <p><small>Este mensaje fue generado automáticamente por FixFlow.</small></p>
</body>
</html>

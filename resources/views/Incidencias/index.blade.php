<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Incidencias</title>
</head>
<body>
<h1>Listado de Incidencias</h1>
@if ($incidencias->isEmpty())
    <p>No hay incidencias registradas.</p>
@else
    <ul>
        @foreach ($incidencias as $incidencia)
            <li>
                {{ $incidencia->titulo }} - {{ $incidencia->estado }}
            </li>
        @endforeach
    </ul>
@endif
</body>
</html>

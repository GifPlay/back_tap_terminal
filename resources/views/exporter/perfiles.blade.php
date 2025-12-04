<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Perfiles</title>
</head>
<body>
<h1>Lista de Perfiles</h1>
<table border="1" cellspacing="0" cellpadding="5">
    <thead>
    <tr>
        <th>Codigo</th>
        <th>Perfil</th>
        <th>Secciones</th>
        <th>Fecha de registro</th>
    </tr>
    </thead>
    <tbody>
    @foreach($perfiles as $perfil)
        <tr>
            <td>{{ $perfil->codigo }}</td>
            <td>{{ $perfil->perfil }}</td>
            <td>
                @if(is_array($perfil->seccionesPermitidas))
                    @foreach($perfil->seccionesPermitidas as $seccion)
                        {{ $seccion }}<br>
                    @endforeach
                @else
                    -
                @endif
            </td>
            <td>{{ $perfil->created_at->format('Y-m-d H:i:s') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>

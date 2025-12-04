<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Usuarios</title>
</head>
<body>
<h1>Lista de Usuarios</h1>
<table border="1" cellspacing="0" cellpadding="5">
    <thead>
    <tr>
        <th>Código</th>
        <th>Nombre</th>
        <th>Usuario</th>
        <th>Teléfono</th>
        <th>Email</th>
        <th>Rol</th>
        <th>Foto</th>
    </tr>
    </thead>
    <tbody>
    @foreach($usuarios as $usuario)
        <tr>
            <td>{{ $usuario->codigo }}</td>
            <td>{{ $usuario->nombre }}</td>
            <td>{{ $usuario->usuario }}</td>
            <td>{{ $usuario->telefono }}</td>
            <td>{{ $usuario->email }}</td>
            <td>{{ $usuario->role }}</td>
            <td><img src="{{ url('storage/fotos/'.$usuario->fotoPerfil) }}" alt="Foto perfil" width="80"></td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Productos</title>
</head>
<body>
<h1>Lista de Productos</h1>
<table border="1" cellspacing="0" cellpadding="5">
    <thead>
    <tr>
        <th>Codigo</th>
        <th>Producto</th>
        <th>Marca</th>
        <th>Precio</th>
        <th>Fecha de registro</th>
    </tr>
    </thead>
    <tbody>
    @foreach($productos as $producto)
        <tr>
            <td>{{ $producto->codigo }}</td>
            <td>{{ $producto->producto }}</td>
            <td>{{ $producto->marca }}</td>
            <td>${{ number_format($producto->precio,2) }}</td>
            <td>{{ $producto->created_at->format('Y-m-d H:i:s') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Orden Exitosa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-green-50 min-h-screen flex items-center justify-center">
    <div class="bg-white p-6 rounded shadow text-center max-w-md">
        <h1 class="text-2xl font-bold text-green-600 mb-4">¡Pedido registrado con éxito!</h1>
        <p class="mb-2">Método de pago: <strong>{{ $metodo }}</strong></p>

        <div class="text-left mt-4 text-sm bg-gray-100 p-4 rounded">
            <p><strong>Departamento:</strong> {{ $direccion['departamento'] ?? '' }}</p>
            <p><strong>Municipio:</strong> {{ $direccion['municipio'] ?? '' }}</p>
            <p><strong>Dirección:</strong> {{ $direccion['direccion'] ?? '' }}</p>
            <p><strong>Teléfono:</strong> {{ $direccion['telefono'] ?? '' }}</p>
        </div>

        <a href="{{ route('productos.index') }}" class="mt-6 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Volver a la tienda
        </a>
    </div>
</body>
</html>

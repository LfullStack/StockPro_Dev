<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Compra Exitosa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <div class="container mx-auto p-6">
        <div class="bg-white p-6 rounded shadow-md max-w-3xl mx-auto">
            <h1 class="text-2xl font-bold text-green-600 mb-4">¡Compra exitosa!</h1>

            <p class="text-gray-600 mb-6">Gracias por tu compra. A continuación te mostramos el resumen:</p>

            <h2 class="text-xl font-semibold mb-2">🛒 Productos:</h2>
            <div class="divide-y divide-gray-200 mb-4">
                @foreach($productos as $item)
                    <div class="flex items-center py-3 space-x-4">
                        <img src="{{ $item['foto'] }}" class="w-16 h-16 object-contain" alt="producto">
                        <div class="flex-1">
                            <p class="font-semibold">{{ $item['nombre'] }}</p>
                            <p class="text-sm text-gray-500">Cantidad: {{ $item['cantidad'] }} × ${{ number_format($item['precio'], 0, ',', '.') }}</p>
                            <p class="text-sm text-gray-700 font-semibold">Total: ${{ number_format($item['precio'] * $item['cantidad'], 0, ',', '.') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <h2 class="text-xl font-semibold mb-2">📍 Datos de entrega:</h2>
            <div class="mb-4 text-gray-700 text-sm">
                <p><strong>Departamento:</strong> {{ $direccion['departamento'] ?? 'N/A' }}</p>
                <p><strong>Municipio:</strong> {{ $direccion['municipio'] ?? 'N/A' }}</p>
                <p><strong>Dirección:</strong> {{ $direccion['direccion'] ?? 'N/A' }}</p>
                <p><strong>Teléfono:</strong> {{ $direccion['telefono'] ?? 'N/A' }}</p>
            </div>

            <h2 class="text-xl font-semibold mb-2">💳 Método de pago:</h2>
            <p class="text-sm text-gray-700 capitalize mb-4">{{ $metodo }}</p>

            <h2 class="text-xl font-semibold mb-2">💰 Resumen:</h2>
            <p class="text-gray-800 text-lg font-bold">
                Total pagado: ${{ number_format($total, 0, ',', '.') }}
            </p>

            <div class="mt-6 text-right">
                <a href="{{ route('inicio') }}" class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">
                    Volver al inicio
                </a>
            </div>
        </div>
    </div>

</body>
</html>

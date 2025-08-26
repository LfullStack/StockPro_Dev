<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura Cliente #{{ $factura->numero_factura }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; margin: 0; padding: 20px; }
        header, footer { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-right { text-align: right; }
        .mt-2 { margin-top: 20px; }
        .no-border td { border: none; }
    </style>
</head>
<body>
    <header>
        <h2>{{ $factura->empresa->nombre }}</h2>
        <p>NIT: {{ $factura->empresa->nit }} | Dirección: {{ $factura->empresa->direccion }}</p>
        <p>Teléfono: {{ $factura->empresa->telefono }} | Email: {{ $factura->empresa->email }}</p>
        <hr>
        <h3>Factura de Venta #{{ $factura->numero_factura }}</h3>
        <p>Fecha: {{ $factura->created_at->format('d/m/Y H:i') }}</p>
    </header>

    <section>
        <table class="no-border">
            <tr>
                <td><strong>Cliente:</strong>
                    @if ($factura->cliente)
                        {{ $factura->cliente->name }}
                    @else
                        MOSTRADOR
                    @endif
                </td>
                <td><strong>Número de factura:</strong> {{ $factura->numero_factura }}</td>
            </tr>
        </table>

        <table class="mt-2">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Descuento</th>
                    <th>IVA</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($factura->items as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->producto->nombre ?? 'Producto eliminado' }}</td>
                        <td>{{ $item->cantidad }}</td>
                        <td class="text-right">${{ number_format($item->precio_unitario, 2) }}</td>
                        <td class="text-right">${{ number_format($item->descuento, 2) }}</td>
                        <td class="text-right">${{ number_format($item->impuesto, 2) }}</td>
                        <td class="text-right">${{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <table class="mt-2 no-border">
            <tr>
                <td class="text-right"><strong>Total:</strong></td>
                <td class="text-right"><strong>${{ number_format($factura->total, 2) }}</strong></td>
            </tr>
        </table>
    </section>

    <footer class="mt-2">
        <p>Gracias por su compra.</p>
    </footer>
</body>
</html>

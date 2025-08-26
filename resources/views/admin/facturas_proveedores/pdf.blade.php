<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura Proveedor #{{ $factura->numero_factura }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header, .footer { text-align: center; margin-bottom: 20px; }
        .content { width: 100%; }
        .table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .table th, .table td { border: 1px solid #ccc; padding: 6px; text-align: left; }
        .table th { background-color: #f0f0f0; }
        .totales td { font-weight: bold; }
    </style>
</head>
<body>

    <div class="header">
        <h2>Factura de Proveedor</h2>
        <p><strong>Número:</strong> {{ $factura->numero_factura }}</p>
        <p><strong>Fecha de Pago:</strong> {{ \Carbon\Carbon::parse($factura->fecha_pago)->format('d/m/Y') }}</p>
    </div>

    <div class="content">
        <h4>Datos del Proveedor</h4>
        <p><strong>Nombre:</strong> {{ $factura->proveedor->nombre }}</p>
        <p><strong>NIT:</strong> {{ $factura->proveedor->nit }}</p>
        <p><strong>Teléfono:</strong> {{ $factura->proveedor->telefono }}</p>
        <p><strong>Dirección:</strong> {{ $factura->proveedor->direccion }}</p>

        <h4>Empresa Receptora</h4>
        <p><strong>Nombre:</strong> {{ $factura->empresa->nombre }}</p>
        <p><strong>NIT:</strong> {{ $factura->empresa->nit }}</p>
        <p><strong>Dirección:</strong> {{ $factura->empresa->direccion }}</p>

        <h4>Ítems de la Factura</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Producto</th>
                    <th>Unidad</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Descuento</th>
                    <th>Impuesto</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($factura->items as $i => $item)
                    @php $total += $item->subtotal; @endphp
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $item->producto->nombre ?? 'Sin nombre' }}</td>
                        <td>{{ $item->producto->unidad_medida_id }}</td>
                        <td>{{ number_format($item->cantidad, 2) }}</td>
                        <td>${{ number_format($item->precio_unitario, 2) }}</td>
                        <td>${{ number_format($item->descuento, 2) }}</td>
                        <td>${{ number_format($item->impuesto, 2) }}</td>
                        <td>${{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot class="totales">
                <tr>
                    <td colspan="7" style="text-align: right;">Total</td>
                    <td>${{ number_format($total, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="footer">
        <p>Documento generado automáticamente - {{ now()->format('d/m/Y H:i') }}</p>
    </div>

</body>
</html>

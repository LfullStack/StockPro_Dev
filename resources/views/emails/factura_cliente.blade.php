@component('mail::message')

# 🎟️ Comprobante de Compra – Bazurto Shop

Hola **{{ $factura->cliente->name ?? 'Cliente' }}**,  
# ¡Gracias por tu compra en Bazurto Shop! 🛍️. A continuación, el resumen de tu transacción:


Tu pedido ha sido procesado exitosamente y encontrarás tu factura adjunta en este correo.

---

### 🧾 Detalles de la Factura:

**Factura N.º:** {{ $factura->numero_factura }}  
**Fecha de emisión:** {{ $factura->created_at->format('d/m/Y') }}  
**Cliente:** {{ $factura->cliente->name }}  
**Email:** {{ $factura->cliente->email }}

---

### 🛒 Ítems Comprados:

@foreach($factura->items as $item)
- {{ $item->cantidad }} x {{ $item->producto->nombre }}  
  @ ${{ number_format($item->precio_unitario, 2) }}  
  **Subtotal:** ${{ number_format($item->subtotal, 2) }}
@endforeach

---

### 💰 Total a pagar: **${{ number_format($factura->total, 2) }}**

---

Se adjunta el comprobante en formato PDF para que lo guardes o imprimas si lo deseas.

¡Estamos muy agradecidos por tu confianza en nosotros! 🎉

¡Esperamos verte pronto de nuevo!  
**Bazurto Shop**  
📦 Productos auténticos, atención garantizada.

@endcomponent

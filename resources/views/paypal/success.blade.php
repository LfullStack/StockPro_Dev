<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito de Compras</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://www.paypal.com/sdk/js?client-id=AcQ8Nx9iA9F7_HbSUrDwEhe4mWOIG1vItqmrBqbFldtnapgalhudVHeb-FU9614DhQ16VrK3bzzxM2Vz&currency=USD"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
       <link rel="shortcut icon" sizes="192x192" href="{{ asset('/img/logo.ico') }}">
    <style>
        [x-cloak] { display: none; }
        @media print {
            .print\\:block { display: block !important; }
            .hidden { display: none !important; }
        }
    </style>
</head>
<body class="bg-gray-100">

    <div x-data="carritoApp()" class="min-h-screen flex flex-col">
        <!-- Navbar -->
        <nav class="bg-gray-600 text-white shadow-md sticky top-0 z-50">
            <div class="container mx-auto px-4 py-3">
                <div class="flex items-center justify-between">
                    <!-- Logo -->
                    <div class="flex items-center space-x-2">
                      <a href="{{ asset('/tienda') }}" class="text-2xl font-bold"> <img src="{{ asset('img/bazurtoShop.png') }}" alt="BazurtoShop" class="h-10"></a>
                    </div>
                    
                    
                    <!-- Search Bar -->
                    <div class="relative w-full max-w-xl mx-4" x-data="{ isOpen: false, searchQuery: '', suggestions: [] }">
                        <div class="relative">
                            <input 
                                type="text" 
                                placeholder="Buscar productos..." 
                                class="w-full py-2 pl-10 pr-4 text-gray-700 bg-white border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400"
                                x-model="searchQuery"
                                @focus="isOpen = true"
                                @click.away="isOpen = false"
                                @keyup="if(searchQuery.length > 2) fetchSuggestions()"
                            >
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                        </div>
                        
                        <!-- Search suggestions -->
                        <div x-show="isOpen && suggestions.length > 0" x-cloak
                            class="absolute z-50 w-full mt-1 bg-white rounded-md shadow-lg">
                            <ul class="py-1">
                                <template x-for="suggestion in suggestions" :key="suggestion.id">
                                    <li @click="selectSuggestion(suggestion)" 
                                        class="px-4 py-2 hover:bg-gray-100 cursor-pointer flex items-center">
                                        <img :src="suggestion.image" class="w-8 h-8 mr-3 object-cover">
                                        <span x-text="suggestion.name"></span>
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </div>
                    
                    <!-- Navigation Icons -->
                    <div class="flex items-center space-x-6">
                     @php
                        $carritoNavbar = session('carrito', []);
                    @endphp
 
                        @auth
                    <div class="flex items-center space-x-2">
                        <span>{{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="bg-red-600 text-white-500 hover:bg-red-700 ml-2 p-2 rounded">Cerrar sesión</button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="bg-gray-800 text-white hover:bg-gray-700 p-2 rounded">Iniciar sesión</a>
                @endauth

                    </div>
                </div>
            </div>
        </nav>
        <!-- Main Content -->
 <div id="factura" class="max-w-3xl mx-auto bg-white shadow-md rounded p-6">
    <div class="text-center mb-4 print:block hidden">
        <img src="{{ url('img/bazurtoShop.png') }}" alt="Logo BazurtoShop"style="height: 60px; margin: 0 auto;">
        <p class="text-sm text-gray-600 mt-2">Fecha de compra: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <h1 class="text-2xl font-bold text-gray-600 mb-4">¡Compra completada con éxito!</h1>

    <p><strong>ID del pedido:</strong> {{ $orderId }}</p>

    <h2 class="text-lg font-semibold mt-4">Productos:</h2>
    <ul class="list-disc ml-6">
        @foreach ($carrito as $item)
            <li>{{ $item['nombre'] }} (x{{ $item['cantidad'] }}) - ${{ number_format($item['precio'] * $item['cantidad'], 2, '.', ',') }}</li>
        @endforeach
    </ul>

    <h2 class="text-lg font-semibold mt-4">Dirección de envío:</h2>
    <ul class="ml-6">
        <li><strong>Departamento:</strong> {{ $direccion['departamento'] }}</li>
        <li><strong>Municipio:</strong> {{ $direccion['municipio'] }}</li>
        <li><strong>Dirección:</strong> {{ $direccion['direccion'] }}</li>
        <li><strong>Teléfono:</strong> {{ $direccion['telefono'] }}</li>
    </ul>

    <p class="mt-4 text-xl font-bold">Total pagado: ${{ $total }}</p>

    <p class="text-xs text-gray-500 mt-8 print:block hidden text-center">
        Esta factura es válida solo para fines informativos. Gracias por su compra en BazurtoShop.
    </p>
</div>


<div class="mt-6 flex gap-4 justify-center">
    <a href="{{ route('tienda.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
        Seguir comprando
    </a>

    <button onclick="imprimirFactura()" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
        Imprimir factura
    </button>
</div>

    </div>
    <!-- Modals -->
<script>
function carritoApp() {
    return {
        modales: { cliente: false, pago: false },
        direccion: { departamento: '', municipio: '', direccion: '', telefono: '' },
        metodoPago: '',
        carrito: @json($carrito),
        total: '{{ number_format($total, 2, '.', '') }}',

        abrirClienteModal() {
            this.modales.cliente = true;
        },
        abrirPagoModal() {
            this.modales.cliente = false;
            this.modales.pago = true;
        },
        cerrarModales() {
            this.modales.cliente = false;
            this.modales.pago = false;
        },
        renderPayPal() {
            setTimeout(() => {
                if (document.getElementById('paypal-button-container').children.length === 0) {
                    paypal.Buttons({
                        createOrder: (data, actions) => {
                            return actions.order.create({
                                purchase_units: [{
                                    amount: { value: this.total }
                                }]
                            });
                        },
                        onApprove: (data, actions) => {
                            return actions.order.capture().then(details => {
                                const payload = new URLSearchParams({
                                    orderID: data.orderID,
                                    direccion: JSON.stringify(this.direccion),
                                    carrito: JSON.stringify(this.carrito),
                                    total: this.total
                                });
                                window.location.href = `/paypal/success?${payload.toString()}`;
                            });
                        }
                    }).render('#paypal-button-container');
                }
            }, 300);
        }
    };
}
</script>
<script>
    function imprimirFactura() {
        const contenido = document.getElementById('factura').innerHTML;
        const ventana = window.open('', '', 'height=700,width=900');
        ventana.document.write(`
            <html>
                <head>
                    <title>Factura de Compra</title>
                    <style>
                        body { font-family: sans-serif; padding: 20px; }
                        h1, h2, p, li { color: #111; }
                        ul { margin-left: 20px; }
                        li { margin-bottom: 5px; }
                    </style>
                </head>
                <body>
                    ${contenido}
                </body>
            </html>
        `);
        ventana.document.close();
        ventana.focus();
        ventana.print();
        ventana.close();
    }
</script>

</body>
</html>

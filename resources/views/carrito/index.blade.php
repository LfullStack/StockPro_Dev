<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito de Compras</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://www.paypal.com/sdk/js?client-id=AcQ8Nx9iA9F7_HbSUrDwEhe4mWOIG1vItqmrBqbFldtnapgalhudVHeb-FU9614DhQ16VrK3bzzxM2Vz&currency=USD"></script>
    <link rel="shortcut icon" sizes="192x192" href="{{ asset('/img/logo.ico') }}">
</head>
<body class="bg-gray-100">

    <div x-data="app()" class="min-h-screen flex flex-col">
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
                        $carrito = session('carrito', []);
                    @endphp

                        <button @click="toggleProfileModal()">
                            <i class="fas fa-user-circle text-xxl"></i>
                        </button>
                        <button @click="toggleOrdersModal()">
                            <i class="fas fa-clipboard-list text-xl"></i>
                        </button>
  
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
                </div></div>
        </nav>

@php
    $total = 0;
    foreach ($carrito as $item) {
        $total += $item['precio'] * $item['cantidad'];
    }
@endphp

<div class="container mx-auto p-6" x-data="carritoApp()">
    <h1 class="text-2xl font-bold mb-6">Carrito de Compras</h1>

    <!--Lista-->
        @forelse ($carrito as $id => $producto)
            <div class="bg-white p-4 rounded shadow mb-4 flex items-center space-x-4" id="producto-{{ $id }}">
                <img src="{{ $producto['foto'] }}" class="w-20 h-20 object-contain rounded">
                <div class="flex-1">
                    <h2 class="font-semibold">{{ $producto['nombre'] }}</h2>
                    <p class="text-gray-600">Cantidad: {{ $producto['cantidad'] }}</p>
                    <p class="text-green-700 font-bold">$ {{ number_format($producto['precio'] * $producto['cantidad'], 0, ',', '.') }}</p>
                </div>
                <button onclick="eliminarDelCarrito({{ $id }})" class="text-red-500 hover:underline">
                    Eliminar
                </button>
            </div>
        @empty
            <p class="text-gray-600">El carrito está vacío.</p>
        @endforelse

    @if(count($carrito))
        <div class="text-right font-semibold text-xl mt-4">
            Total: ${{ number_format($total, 0, ',', '.') }}
        </div>

        @auth
            <button @click="abrirClienteModal"
                class="mt-4 bg-gray-600 text-white px-6 py-2 rounded hover:bg-gray-700">
                Pagar
            </button>
        @else
        <a href="{{ route('login') }}" class="bg-gray-800 text-white hover:bg-gray-700 p-2 rounded">
        Iniciar sesión para pagar
        </a>


        @endauth
    @endif

    <!-- Modal Cliente -->
    <div x-show="modales.cliente" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded shadow w-full max-w-md">
            <h2 class="text-xl font-bold mb-4">Datos para la entrega</h2>
            <form @submit.prevent="abrirPagoModal">
                <div class="space-y-2">
                    <input type="text" placeholder="Departamento" class="w-full border p-2 rounded" x-model="direccion.departamento" required>
                    <input type="text" placeholder="Municipio" class="w-full border p-2 rounded" x-model="direccion.municipio" required>
                    <input type="text" placeholder="Dirección" class="w-full border p-2 rounded" x-model="direccion.direccion" required>
                    <input type="text" placeholder="Teléfono" class="w-full border p-2 rounded" x-model="direccion.telefono" required>
                </div>
                <div class="mt-4 text-right">
                    <button type="button" @click="cerrarModales" class="mr-2 text-gray-500 hover:underline">Cancelar</button>
                    <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded">Continuar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Método de Pago -->
    <div x-show="modales.pago" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded shadow w-full max-w-md" x-init="$watch('metodoPago', value => { if (value === 'paypal') renderPayPal(); })">
            <h2 class="text-xl font-bold mb-4">Selecciona el método de pago</h2>

            <div class="space-y-3">
                <label class="flex items-center space-x-2">
                    <input type="radio" name="metodo" value="contraentrega" x-model="metodoPago">
                    <span>Pago contraentrega</span>
                </label>
                <label class="flex items-center space-x-2">
                    <input type="radio" name="metodo" value="paypal" x-model="metodoPago">
                    <span>PayPal (Sandbox)</span>
                </label>
            </div>

            <!-- Contraentrega -->
            <div class="mt-4 text-right" x-show="metodoPago === 'contraentrega'">
                <form method="POST" action="{{ route('orden.contraentrega') }}">
                    @csrf
                    <input type="hidden" name="direccion" :value="JSON.stringify(direccion)">
                    <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded">Confirmar Pedido</button>
                </form>
            </div>

            <!-- PayPal -->
            <div class="mt-6" x-show="metodoPago === 'paypal'">
                <div id="paypal-button-container"></div>
            </div>

        </div>
    </div>
</div>

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

</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BazurtoShop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <link rel="shortcut icon" sizes="192x192" href="{{ asset('/img/logo.ico') }}">

 <link id="app-style" href="{{ asset('css/inicio.css') }}" rel="stylesheet">
    <style id="app-style">
        [x-cloak] { display: none !important; }
        
        .swiper {
            width: 100%;
            height: 500px;
        }
        
        .swiper-slide {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .modal-backdrop {
            backdrop-filter: blur(3px);
        }
        
        .product-card {
            transition: transform 0.3s ease;
        }
        
        .product-card:hover {
            transform: translateY(-5px);
        }
        
        .loader {
            border-top-color: #3498db;
            animation: spinner 1.5s linear infinite;
        }
        
        @keyframes spinner {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body class="bg-gray-200">
   
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

                        <!-- Botón carrito con dropdown - Versión mejorada -->
                        <div class="relative" x-data="{ isOpen: false }" @click.outside="isOpen = false">
                            <button @click="isOpen = !isOpen" class="relative text-white-700 hover:text-gray-900 focus:outline-none">
                                <i class="fas fa-shopping-cart text-xl"></i>
                                @if(count($carrito))
                                    <span class="absolute -top-2 -right-2 bg-red-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                        {{ count($carrito) }}
                                    </span>
                                @endif
                            </button>

                            <!-- Dropdown del carrito -->
                            <div x-show="isOpen" x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                                class="absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg z-50 border border-gray-200 text-black"
                                id="cart-dropdown">
                                
                                <!-- Contenido se actualizará dinámicamente -->
                                @include('partials.cart-dropdown-content')
                            </div>
                        </div>

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
                        <a href="{{ route('login', ['redirect_to' => url()->current()]) }}" class="bg-gray-800 text-white hover:bg-gray-700 p-2 rounded"> Iniciar sesión</a>
                @endauth
                    </div>
                </div>
                
                <!-- Categories menu -->
           
                <div style="display: none;">
                    {{ print_r($categorias) }}
                </div>
                <!-- Categories menu --->
                    <div class="pt-2 pb-1 overflow-x-auto whitespace-nowrap hide-scrollbar"
                        x-data="{ selectedCategory: null }">
                        <template x-for="category in categories" :key="category.id">
                            <a href="#" 
                            @click.prevent="selectedCategory = category"
                            class="px-4 py-1 mr-2 text-sm rounded-full hover:bg-white hover:text-indigo-600 transition-colors"
                            :class="selectedCategory && selectedCategory.id === category.id ? 'bg-white text-indigo-600' : ''">
                                <span x-text="category.nombre"></span>
                            </a>
                        </template>
                    </div>
            </div>
        </nav>
        
        <!-- Main content -->
        <main class="flex-grow">
          <!-- Hero Banner con curva moderna -->
<div class="swiper banner-swiper">
    <div class="swiper-wrapper">

        <!-- Slide 1 -->
        <div class="swiper-slide relative bg-gray-900 min-h-[500px] flex items-center">
            <div class="absolute inset-0">
                <img src="https://cdn.pixabay.com/photo/2018/01/16/10/18/headphones-3085681_1280.jpg"
                     class="w-full h-full object-cover opacity-30" alt="Auriculares">
            </div>

            <!-- Bloque de fondo curveado -->
            <div class="relative z-10 container mx-auto px-6 py-12 flex flex-col md:flex-row items-center justify-between w-full">
                <div class="relative bg-white/90 text-gray-900 p-8 rounded-3xl shadow-xl max-w-xl clip-custom">
                    <h2 class="text-4xl font-bold mb-4">Auriculares Bluetooth</h2>
                    <p class="mb-6">Sonido nítido, cancelación activa y hasta 30h de batería.</p>
                    <button class="bg-gray-800 text-white px-6 py-2 rounded-md hover:bg-gray-700 transition font-semibold">Ver oferta</button>
                </div>
            </div>
        </div>

        <!-- Slide 2 -->
        <div class="swiper-slide relative bg-zinc-900 min-h-[500px] flex items-center">
            <div class="absolute inset-0">
                <img src="https://cdn.pixabay.com/photo/2015/06/25/17/21/smart-watch-821557_1280.jpg"
                     class="w-full h-full object-cover opacity-30" alt="Smartwatch">
            </div>
            <div class="relative z-10 container mx-auto px-6 py-12 flex flex-col md:flex-row items-center justify-between w-full">
                <div class="relative bg-white/90 text-gray-900 p-8 rounded-3xl shadow-xl max-w-xl clip-custom">
                    <h2 class="text-4xl font-bold mb-4">Smartwatches en oferta</h2>
                    <p class="mb-6">Hasta 40% de descuento en modelos seleccionados.</p>
                    <button class="bg-zinc-800 text-white px-6 py-2 rounded-md hover:bg-zinc-700 transition font-semibold">Comprar ahora</button>
                </div>
            </div>
        </div>

        <!-- Slide 3 -->
        <div class="swiper-slide relative bg-gray-800 min-h-[500px] flex items-center">
            <div class="absolute inset-0">
                <img src="https://cdn.pixabay.com/photo/2016/03/27/07/12/apple-1282241_1280.jpg"
                     class="w-full h-full object-cover opacity-30" alt="Laptop Gaming">
            </div>
            <div class="relative z-10 container mx-auto px-6 py-12 flex flex-col md:flex-row items-center justify-between w-full">
                <div class="relative bg-white/90 text-gray-900 p-8 rounded-3xl shadow-xl max-w-xl clip-custom">
                    <h2 class="text-4xl font-bold mb-4">Laptops Gaming</h2>
                    <p class="mb-6">Potencia, velocidad y rendimiento para gamers exigentes.</p>
                    <button class="bg-gray-900 text-white px-6 py-2 rounded-md hover:bg-gray-700 transition font-semibold">Explorar</button>
                </div>
            </div>
        </div>

    </div>

    <!-- Controles Swiper -->
    <div class="swiper-pagination"></div>
    <div class="swiper-button-next text-white"></div>
    <div class="swiper-button-prev text-white"></div>
</div>

<section class="py-8">
    <div class="container bg-white mx-auto px-4 shadow-lg rounded-lg">
        <h2 class="text-2xl font-bold text-black text-bolder pt-6">Productos para el Hogar</h2>

        @if(isset($productosHogar) && $productosHogar->count() > 0)
        <div class="relative">
            <!-- Swiper Container - Mismo estilo que productos destacados -->
            <div class="swiper productos-hogar-swiper">
                <div class="swiper-wrapper">
                    @foreach($productosHogar as $producto)
                    <div class="swiper-slide" style="width: auto;">
                        <div class="w-64 h-80 bg-white shadow rounded-lg overflow-hidden hover:shadow-lg transition duration-300 flex flex-col">
                            <!-- Imagen del producto -->
                            <div class="h-40 bg-white flex items-center justify-center">
                                @if($producto->foto && filter_var($producto->foto, FILTER_VALIDATE_URL))
                                    <img src="{{ $producto->foto }}" alt="{{ $producto->nombre }}" class="h-full object-contain">
                                @elseif($producto->foto)
                                    <img src="{{ asset('storage/'.$producto->foto) }}" alt="{{ $producto->nombre }}" class="h-full object-contain">
                                @else
                                    <div class="text-gray-400 text-sm">Sin imagen</div>
                                @endif
                            </div>

                            <!-- Contenido -->
                            <div class="p-3 flex flex-col justify-between flex-grow">
                                <div>
                                    <h5 class="text-black font-semibold mb-1 line-clamp-2">{{ $producto->nombre }}</h5>
                                    <p class="text-sm text-green-600 font-bold mb-2">
                                        ${{ number_format($producto->precio, 0, ',', '.') }}
                                    </p>
                                </div>

                                <!-- Botón para añadir al carrito -->
                                <form method="POST" action="{{ route('carrito.agregar', $producto->id) }}" class="add-to-cart-form">
                                    @csrf
                                    <button type="submit" 
                                            class="bg-gray-600 text-white px-4 py-2 mt-2 rounded hover:bg-gray-700 w-full"
                                            @if($producto->inventario && $producto->inventario->cantidad <= 0) disabled @endif>
                                        @if($producto->inventario && $producto->inventario->cantidad <= 0)
                                            Agotado
                                        @else
                                            Añadir al carrito
                                        @endif
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Controles de navegación - Igual que destacados -->
                <div class="swiper-button-prev productos-hogar-prev !text-gray-700"></div>
                <div class="swiper-button-next productos-hogar-next !text-gray-700"></div>
                
                <!-- Paginación -->
                <div class="swiper-pagination productos-hogar-pagination"></div>
            </div>
        </div>
        @else
        <div class="text-center py-8">
            <i class="fas fa-box-open text-gray-300 text-4xl mb-3"></i>
            <p class="text-gray-500">No hay productos disponibles en esta categoría</p>
        </div>
        @endif
    </div>
</section>

<section class="container  mx-auto px-4 rounded-lg mb-6">
    <!-- Contenedor con el mismo ancho que productos destacados -->
    <div class="flex flex-col md:flex-row gap-4 w-full">
        <!-- Card Promocional 1 - Mismo ancho que los productos -->
        <div class="w-full md:w-[calc(50%-8px)] bg-gradient-to-r from-gray-600 to-gray-800 rounded-lg shadow-md overflow-hidden text-white">
            <div class="p-4 h-full flex flex-col">
                <div class="flex justify-between items-start mb-2">
                    <h2 class="text-xl font-bold">APROVECHA AHORA</h2>
                    <span class="bg-gray-800 text-white px-2 py-1 rounded-full text-xs">%</span>
                </div>
                
                <h3 class="text-lg font-semibold mb-2">DESCUBRE LAS MEJORES OFERTAS</h3>
                
                <div class="flex flex-wrap gap-1 mb-3">
                    <span class="bg-gray-700/50 px-2 py-1 rounded-full text-xs">Ver todo</span>
                    <span class="bg-gray-700/50 px-2 py-1 rounded-full text-xs">$</span>
                    <span class="bg-red-600 px-2 py-1 rounded-full text-xs font-bold">REMATES</span>
                    <span class="bg-gray-700/50 px-2 py-1 rounded-full text-xs">3 CUOTAS 0%</span>
                </div>
                
                <div class="mt-auto flex justify-between items-center">
                    <span class="text-xs bg-gray-800/70 px-2 py-1 rounded">BazurtoShop</span>
                </div>
            </div>
        </div>

        <!-- Card Promocional 2 - Mismo ancho que los productos -->
        <div class="w-full md:w-[calc(50%-8px)] bg-gradient-to-br from-gray-700 to-gray-900 rounded-lg shadow-md overflow-hidden text-white border-l-4 border-indigo-500">
            <div class="p-4 h-full flex flex-col relative">
                <div class="absolute top-3 right-3 bg-indigo-600 text-white px-2 py-1 rounded text-xs font-bold">NPV</div>
                
                <h2 class="text-xl font-bold mb-1">OFERTAS FLASH</h2>
                <h3 class="text-md text-gray-300 mb-2">Solo por 24 horas</h3>
                
                <div class="flex flex-wrap gap-1 mb-3">
                    <span class="bg-gray-600 px-2 py-1 rounded-full text-xs flex items-center">
                        <i class="fas fa-bolt text-yellow-400 mr-1"></i> Flash
                    </span>
                    <span class="bg-gray-600 px-2 py-1 rounded-full text-xs">-50%</span>
                    <span class="bg-red-600 px-2 py-1 rounded-full text-xs font-bold">ÚLTIMAS UNIDADES</span>
                </div>
                
                <div class="mt-auto">
                    <span class="text-xs bg-gray-800 px-2 py-1 rounded flex items-center">
                        <i class="fas fa-clock mr-1"></i> Encuentra variedad en nuestros productos.
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>
            
<!-- Featured Products - Versión corregida -->
<div class="container bg-white mx-auto px-4 shadow-lg rounded-lg pb-0 pt-8 mb-8">
    <h2 class="text-2xl text-black font-bold">Productos Destacados</h2>

    <div class="relative">
        <!-- Swiper Container -->
        <div class="swiper productos-swiper">
            <div class="swiper-wrapper">
                @foreach($productos as $producto)
                <div class="swiper-slide" style="width: auto;">
                    <div class="w-64 h-80 bg-white shadow rounded-lg overflow-hidden hover:shadow-lg transition duration-300 flex flex-col">
                        <!-- Imagen del producto -->
                        <div class="h-40 bg-white flex items-center justify-center">
                            @if($producto->foto && filter_var($producto->foto, FILTER_VALIDATE_URL))
                                <img src="{{ $producto->foto }}" alt="{{ $producto->nombre }}" class="h-full object-contain">
                            @else
                                <div class="text-gray-400 text-sm">Sin imagen</div>
                            @endif
                        </div>

                        <!-- Contenido -->
                        <div class="p-3 flex flex-col justify-between flex-grow">
                            <div>
                                <h5 class="text-black font-semibold mb-1 line-clamp-2">{{ $producto->nombre }}</h5>
                                <p class="text-sm text-green-600 font-bold mb-2">${{ number_format($producto->precio, 0, ',', '.') }}</p>
                            </div>

                            <!-- Botón para añadir al carrito -->
                            <form method="POST" action="{{ route('carrito.agregar', $producto->id) }}" class="add-to-cart-form">
                                @csrf
                                <button type="submit" class="bg-gray-600 text-white px-4 py-2 mt-2 rounded hover:bg-gray-700 w-full">
                                    Añadir al carrito
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
                <!-- Botones de navegación -->
                <div class="swiper-button-prev productos-destacados-prev text-gray-700"></div>
                <div class="swiper-button-next productos-destacados-next text-gray-700"></div>

                <!-- Paginación -->
                <div class="swiper-pagination productos-destacados-pagination"></div>
            </div>
        </div>
    </div>

        </main>
        
        <!-- Footer -->
        <footer class="bg-gray-800 text-white py-8">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div>
                        <h3 class="text-xl font-bold mb-4">BazurtoShop</h3>
                        <p class="text-gray-400">Encuentra una gran variedad de productos en nuestra web.</p>
                        <div class="flex space-x-4 mt-4">
                            <a href="javascript:void(0)" class="text-gray-400 hover:text-white"><i class="fab fa-facebook-f"></i></a>
                            <a href="javascript:void(0)" class="text-gray-400 hover:text-white"><i class="fab fa-twitter"></i></a>
                            <a href="javascript:void(0)" class="text-gray-400 hover:text-white"><i class="fab fa-instagram"></i></a>
                            <a href="javascript:void(0)" class="text-gray-400 hover:text-white"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold mb-4">Enlaces rápidos</h4>
                        <ul class="space-y-2">
                            <li><a href="/" class="text-gray-400 hover:text-white">Inicio</a></li>
                            <li><a href="/productos" class="text-gray-400 hover:text-white">Productos</a></li>
                            <li><a href="/ofertas" class="text-gray-400 hover:text-white">Ofertas</a></li>
                            <li><a href="/contacto" class="text-gray-400 hover:text-white">Contacto</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold mb-4">Ayuda</h4>
                        <ul class="space-y-2">
                            <li><a href="javascript:void(0)" class="text-gray-400 hover:text-white">FAQ</a></li>
                            <li><a href="javascript:void(0)" class="text-gray-400 hover:text-white">Envíos</a></li>
                            <li><a href="javascript:void(0)" class="text-gray-400 hover:text-white">Devoluciones</a></li>
                            <li><a href="javascript:void(0)" class="text-gray-400 hover:text-white">Términos y condiciones</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold mb-4">Contacto</h4>
                        <ul class="space-y-2 text-gray-400">
                            <li class="flex items-start">
                                <i class="fas fa-map-marker-alt mt-1 mr-2"></i>
                                <span>Av. Tecnología 123, Ciudad Digital</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-phone-alt mr-2"></i>
                                <span>+123 456 7890</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-envelope mr-2"></i>
                                <span>info@techshop.com</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="border-top border-dark mt-5 pt-3 text-muted">
                   <div class="d-flex justify-content-center align-items-center gap-2">
                    </div>
                    <div class="container-fluid d-flex justify-content-center text-center mt-5"><span>2025 BazurtoShop. Todos Los Derechos Reservados.</span></div>
                       
                </div>
        </footer>
        
        <!-- Product Modal -->
        <div x-show="productModal.isOpen" x-cloak @keydown.escape.window="productModal.isOpen = false" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-black bg-opacity-50 modal-backdrop" @click="productModal.isOpen = false"></div>
                <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full mx-auto z-10 overflow-hidden relative">
                    <button @click="productModal.isOpen = false" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2">
                        <!-- Product Image -->
                        <div class="p-6 bg-gray-100 flex items-center justify-center">
                            <img :src="productModal.product.image" :alt="productModal.product.name" class="max-h-80 object-contain">
                        </div>
                        
                        <!-- Product Info -->
                        <div class="p-6">
                            <h2 class="text-2xl font-bold mb-2" x-text="productModal.product.name"></h2>
                            <div class="flex items-center mb-4">
                                <div class="flex text-amber-400">
                                    <template x-for="i in 5">
                                        <i class="fas fa-star" :class="i <= productModal.product.rating ? 'text-amber-400' : 'text-gray-300'"></i>
                                    </template>
                                </div>
                                <span class="text-gray-600 text-sm ml-2" x-text="productModal.product.reviews + ' reseñas'"></span>
                            </div>
                            
                            <div class="mb-4">
                                <span class="text-2xl font-bold text-indigo-600" x-text="'$' + productModal.product.price?.toFixed(2)"></span>
                                <span x-show="productModal.product.oldPrice" class="text-lg text-gray-500 line-through ml-2" x-text="'$' + productModal.product.oldPrice?.toFixed(2)"></span>
                                <span x-show="productModal.product.discount" class="ml-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded" x-text="'-' + productModal.product.discount + '%'"></span>
                            </div>
                            
                            <p class="text-gray-600 mb-6" x-text="productModal.product.description"></p>
                            
                            <div class="mb-6">
                                <h3 class="font-semibold mb-2">Cantidad</h3>
                                <div class="flex items-center">
                                    <button @click="decrementQuantity()" class="w-10 h-10 bg-gray-200 rounded-l-lg flex items-center justify-center hover:bg-gray-300">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input type="number" min="1" max="99" x-model="productModal.quantity" class="w-16 h-10 text-center border-t border-b border-gray-200">
                                    <button @click="incrementQuantity()" class="w-10 h-10 bg-gray-200 rounded-r-lg flex items-center justify-center hover:bg-gray-300">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="flex space-x-4">
                                <button @click="addToCart(productModal.product, productModal.quantity)" 
                                        class="flex-1 bg-indigo-600 text-white py-3 rounded-lg hover:bg-indigo-700 flex items-center justify-center"
                                        :class="{ 'opacity-75 cursor-not-allowed': isLoading }"
                                        :disabled="isLoading">
                                    <template x-if="isLoading">
                                        <div class="w-5 h-5 border-2 border-white border-solid rounded-full loader mr-2"></div>
                                    </template>
                                    <span>Añadir al carrito</span>
                                </button>
                                <button @click="buyNow(productModal.product, productModal.quantity)" 
                                        class="flex-1 bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 flex items-center justify-center"
                                        :class="{ 'opacity-75 cursor-not-allowed': isLoading }"
                                        :disabled="isLoading">
                                    <template x-if="isLoading">
                                        <div class="w-5 h-5 border-2 border-white border-solid rounded-full loader mr-2"></div>
                                    </template>
                                    <span>Comprar ahora</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Cart Modal -->
        <div x-show="cartModal.isOpen" x-cloak @keydown.escape.window="cartModal.isOpen = false" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-black bg-opacity-50 modal-backdrop" @click="cartModal.isOpen = false"></div>
                <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-auto z-10 overflow-hidden">
                    <div class="flex justify-between items-center p-6 border-b">
                        <h2 class="text-2xl font-bold">Carrito de compras</h2>
                        <button @click="cartModal.isOpen = false" class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                    
                    <div class="p-6 max-h-96 overflow-y-auto">
                        <template x-if="cart.items.length === 0">
                            <div class="text-center py-8">
                                <i class="fas fa-shopping-cart text-gray-300 text-5xl mb-4"></i>
                                <p class="text-gray-500">Tu carrito está vacío</p>
                                <button @click="cartModal.isOpen = false" class="mt-4 bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                                    Explorar productos
                                </button>
                            </div>
                        </template>
                        
                        <template x-if="cart.items.length > 0">
                            <div>
                                <ul class="divide-y">
                                    <template x-for="(item, index) in cart.items" :key="index">
                                        <li class="py-4 flex">
                                            <img :src="item.image" :alt="item.name" class="h-20 w-20 object-cover rounded">
                                            <div class="ml-4 flex-1">
                                                <h3 class="text-lg font-semibold" x-text="item.name"></h3>
                                                <div class="flex justify-between mt-1">
                                                    <div class="text-gray-600">
                                                        <span x-text="'$' + item.price.toFixed(2)"></span>
                                                        <span class="mx-2">×</span>
                                                        <span x-text="item.quantity"></span>
                                                    </div>
                                                    <div class="font-semibold" x-text="'$' + (item.price * item.quantity).toFixed(2)"></div>
                                                </div>
                                                <div class="flex items-center mt-2">
                                                    <button @click="updateCartItem(index, item.quantity - 1)" class="text-gray-500 hover:text-indigo-600">
                                                        <i class="fas fa-minus-circle"></i>
                                                    </button>
                                                    <span class="mx-2" x-text="item.quantity"></span>
                                                    <button @click="updateCartItem(index, item.quantity + 1)" class="text-gray-500 hover:text-indigo-600">
                                                        <i class="fas fa-plus-circle"></i>
                                                    </button>
                                                    <button @click="removeFromCart(index)" class="ml-auto text-red-500 hover:text-red-700">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </li>
                                    </template>
                                </ul>
                            </div>
                        </template>
                    </div>
                    
                    <template x-if="cart.items.length > 0">
                        <div class="border-t p-6">
                            <div class="flex justify-between mb-2">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-semibold" x-text="'$' + calculateSubtotal().toFixed(2)"></span>
                            </div>
                            <div class="flex justify-between mb-4">
                                <span class="text-gray-600">Envío</span>
                                <span class="text-green-600 font-semibold">Gratis</span>
                            </div>
                            <div class="flex justify-between text-lg font-bold mb-6">
                                <span>Total</span>
                                <span x-text="'$' + calculateSubtotal().toFixed(2)"></span>
                            </div>
                            <button @click="checkout()" 
                                    class="w-full bg-indigo-600 text-white py-3 rounded-lg hover:bg-indigo-700 flex items-center justify-center"
                                    :class="{ 'opacity-75 cursor-not-allowed': isLoading }"
                                    :disabled="isLoading">
                                <template x-if="isLoading">
                                    <div class="w-5 h-5 border-2 border-white border-solid rounded-full loader mr-2"></div>
                                </template>
                                <span>Proceder al pago</span>
                            </button>
                        </div>
                    </template>
                </div>
            </div>
        </div>
        
        <!-- Profile Modal -->
        <div x-show="profileModal.isOpen" x-cloak @keydown.escape.window="profileModal.isOpen = false" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-black bg-opacity-50 modal-backdrop" @click="profileModal.isOpen = false"></div>
                <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-auto z-10 overflow-hidden">
                    <div class="flex justify-between items-center p-6 border-b">
                        <h2 class="text-2xl font-bold">Mi perfil</h2>
                        <button @click="profileModal.isOpen = false" class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                    
                    <div class="p-6">
                        <form @submit.prevent="saveProfile">
                            <div class="mb-6 flex justify-center">
                                <div class="relative">
                                    <div class="h-24 w-24 rounded-full bg-indigo-100 flex items-center justify-center">
                                        <i class="fas fa-user text-indigo-600 text-4xl"></i>
                                    </div>
                                    <button type="button" class="absolute bottom-0 right-0 bg-indigo-600 text-white p-2 rounded-full hover:bg-indigo-700">
                                        <i class="fas fa-camera"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-gray-700 mb-2">Nombre</label>
                                    <input type="text" x-model="profileModal.user.firstName" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-400">
                                </div>
                                <div>
                                    <label class="block text-gray-700 mb-2">Apellido</label>
                                    <input type="text" x-model="profileModal.user.lastName" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-400">
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="block text-gray-700 mb-2">Email</label>
                                <input type="email" x-model="profileModal.user.email" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-400">
                            </div>
                            
                            <div class="mb-4">
                                <label class="block text-gray-700 mb-2">Teléfono</label>
                                <input type="tel" x-model="profileModal.user.phone" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-400">
                            </div>
                            
                            <h3 class="font-semibold text-lg mb-4 mt-8">Dirección de envío</h3>
                            
                            <div class="mb-4">
                                <label class="block text-gray-700 mb-2">Dirección</label>
                                <input type="text" x-model="profileModal.user.address" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-400">
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-gray-700 mb-2">Ciudad</label>
                                    <input type="text" x-model="profileModal.user.city" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-400">
                                </div>
                                <div>
                                    <label class="block text-gray-700 mb-2">Estado</label>
                                    <input type="text" x-model="profileModal.user.state" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-400">
                                </div>
                                <div>
                                    <label class="block text-gray-700 mb-2">Código Postal</label>
                                    <input type="text" x-model="profileModal.user.zipCode" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-400">
                                </div>
                            </div>
                            
                            <div class="mt-8 flex justify-end">
                                <button type="button" @click="profileModal.isOpen = false" class="px-4 py-2 border rounded text-gray-600 hover:bg-gray-100 mr-2">Cancelar</button>
                                <button type="submit" 
                                        class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 flex items-center"
                                        :class="{ 'opacity-75 cursor-not-allowed': isLoading }"
                                        :disabled="isLoading">
                                    <template x-if="isLoading">
                                        <div class="w-4 h-4 border-2 border-white border-solid rounded-full loader mr-2"></div>
                                    </template>
                                    <span>Guardar cambios</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Orders Modal -->
        <div x-show="ordersModal.isOpen" x-cloak @keydown.escape.window="ordersModal.isOpen = false" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-black bg-opacity-50 modal-backdrop" @click="ordersModal.isOpen = false"></div>
                <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full mx-auto z-10 overflow-hidden">
                    <div class="flex justify-between items-center p-6 border-b">
                        <h2 class="text-2xl font-bold">Mis pedidos</h2>
                        <button @click="ordersModal.isOpen = false" class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                    
                    <div class="p-6 max-h-96 overflow-y-auto">
                        <template x-if="ordersModal.orders.length === 0">
                            <div class="text-center py-8">
                                <i class="fas fa-box-open text-gray-300 text-5xl mb-4"></i>
                                <p class="text-gray-500">No tienes pedidos recientes</p>
                                <button @click="ordersModal.isOpen = false" class="mt-4 bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                                    Explorar productos
                                </button>
                            </div>
                        </template>
                        
                        <template x-if="ordersModal.orders.length > 0">
                            <div>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pedido</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            <template x-for="order in ordersModal.orders" :key="order.id">
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <span class="font-semibold" x-text="'#' + order.id"></span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap" x-text="order.date"></td>
                                                    <td class="px-6 py-4 whitespace-nowrap font-semibold" x-text="'$' + order.total.toFixed(2)"></td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full" 
                                                              :class="{
                                                                  'bg-green-100 text-green-800': order.status === 'Entregado',
                                                                  'bg-yellow-100 text-yellow-800': order.status === 'En camino',
                                                                  'bg-blue-100 text-blue-800': order.status === 'Procesando',
                                                                  'bg-red-100 text-red-800': order.status === 'Cancelado'
                                                              }"
                                                              x-text="order.status"></span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <button @click="viewOrderDetails(order)" class="text-indigo-600 hover:text-indigo-900">Ver detalles</button>
                                                    </td>
                                                </tr>
                                            </template>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Settings Modal -->
        <div x-show="settingsModal.isOpen" x-cloak @keydown.escape.window="settingsModal.isOpen = false" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-black bg-opacity-50 modal-backdrop" @click="settingsModal.isOpen = false"></div>
                <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-auto z-10 overflow-hidden">
                    <div class="flex justify-between items-center p-6 border-b">
                        <h2 class="text-2xl font-bold">Configuración</h2>
                        <button @click="settingsModal.isOpen = false" class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                    
                    <div class="p-6">
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold mb-4">Notificaciones</h3>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-700">Emails promocionales</span>
                                    <div class="relative inline-block w-12 h-6 transition duration-200 ease-in-out">
                                        <input type="checkbox" x-model="settingsModal.notifications.promotions" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer">
                                        <label class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-700">Actualizaciones de pedidos</span>
                                    <div class="relative inline-block w-12 h-6 transition duration-200 ease-in-out">
                                        <input type="checkbox" x-model="settingsModal.notifications.orderUpdates" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer">
                                        <label class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-700">Nuevos productos</span>
                                    <div class="relative inline-block w-12 h-6 transition duration-200 ease-in-out">
                                        <input type="checkbox" x-model="settingsModal.notifications.newProducts" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer">
                                        <label class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold mb-4">Privacidad</h3>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-700">Compartir datos de compra</span>
                                    <div class="relative inline-block w-12 h-6 transition duration-200 ease-in-out">
                                        <input type="checkbox" x-model="settingsModal.privacy.shareData" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer">
                                        <label class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-700">Cookies de terceros</span>
                                    <div class="relative inline-block w-12 h-6 transition duration-200 ease-in-out">
                                        <input type="checkbox" x-model="settingsModal.privacy.thirdPartyCookies" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer">
                                        <label class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold mb-4">Cambiar contraseña</h3>
                            <form @submit.prevent="changePassword">
                                <div class="mb-4">
                                    <label class="block text-gray-700 mb-2">Contraseña actual</label>
                                    <input type="password" x-model="settingsModal.password.current" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-400">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-gray-700 mb-2">Nueva contraseña</label>
                                    <input type="password" x-model="settingsModal.password.new" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-400">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-gray-700 mb-2">Confirmar nueva contraseña</label>
                                    <input type="password" x-model="settingsModal.password.confirm" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-400">
                                </div>
                                <div class="flex justify-end">
                                    <button type="submit" 
                                            class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 flex items-center"
                                            :class="{ 'opacity-75 cursor-not-allowed': isLoading }"
                                            :disabled="isLoading">
                                        <template x-if="isLoading">
                                            <div class="w-4 h-4 border-2 border-white border-solid rounded-full loader mr-2"></div>
                                        </template>
                                        <span>Cambiar contraseña</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                        
                        <div class="pt-4 border-t">
                            <button @click="logout()" class="flex items-center text-red-600 hover:text-red-800">
                                <i class="fas fa-sign-out-alt mr-2"></i>
                                <span>Cerrar sesión</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Toast Notification -->
        <div x-show="toast.show" x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform translate-y-2"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 transform translate-y-0"
             x-transition:leave-end="opacity-0 transform translate-y-2"
             @click="toast.show = false"
             class="fixed bottom-4 right-4 px-4 py-2 rounded-lg shadow-lg flex items-center"
             :class="{
                 'bg-green-500': toast.type === 'success',
                 'bg-red-500': toast.type === 'error',
                 'bg-blue-500': toast.type === 'info'
             }">
            <i class="fas mr-2"
               :class="{
                   'fa-check-circle': toast.type === 'success',
                   'fa-exclamation-circle': toast.type === 'error',
                   'fa-info-circle': toast.type === 'info'
               }"></i>
            <span class="text-white" x-text="toast.message"></span>
        </div>
    </div>

<!-- Back to Top Button -->
  <div class="back-to-top" id="backToTop">
    <i class="fas fa-arrow-up"></i>
  </div>




    <script>
    const productosDesdeLaravel = @json($productos);
    </script>

   <script id="app-script">
    function app() {
        return {
            // CATEGORÍAS DINÁMICAS desde la base de datos
            categories: @json($categorias),
            
            selectedCategory: null,
            featuredProducts: [
                {
                    id: 1,
                    name: 'Smartphone XYZ Pro',
                    description: 'Smartphone de última generación con cámara de 108MP, 12GB RAM y pantalla AMOLED de 6.7".',
                    price: 899.99,
                    oldPrice: 999.99,
                    image: 'https://cdn.pixabay.com/photo/2016/11/29/12/30/phone-1869510_1280.jpg',
                    rating: 4.5,
                    reviews: 128
                },
                {
                    id: 2,
                    name: 'Laptop UltraBook',
                    description: 'Laptop ultradelgada con procesador de última generación, 16GB RAM y 512GB SSD.',
                    price: 1299.99,
                    image: 'https://cdn.pixabay.com/photo/2016/03/27/07/12/apple-1282241_1280.jpg',
                    rating: 4.8,
                    reviews: 95
                },
                {
                    id: 3,
                    name: 'Auriculares NoiseCancel',
                    description: 'Auriculares con cancelación de ruido, 30 horas de batería y conexión Bluetooth 5.0.',
                    price: 249.99,
                    oldPrice: 299.99,
                    image: 'https://cdn.pixabay.com/photo/2016/09/13/08/44/headphones-1666720_1280.jpg',
                    rating: 4.7,
                    reviews: 204
                },
                {
                    id: 4,
                    name: 'Smartwatch FitTrack',
                    description: 'Reloj inteligente con seguimiento de actividad física, monitoreo cardíaco y GPS integrado.',
                    price: 179.99,
                    image: 'https://cdn.pixabay.com/photo/2015/06/25/17/21/smart-watch-821557_1280.jpg',
                    rating: 4.3,
                    reviews: 156
                }
            ],
            dealProducts: [
                {
                    id: 5,
                    name: 'Tablet UltraView 10"',
                    description: 'Tablet con pantalla 2K de 10", procesador octa-core y 128GB de almacenamiento.',
                    price: 299.99,
                    oldPrice: 399.99,
                    discount: 25,
                    image: 'https://th.bing.com/th/id/OIP.1eUOj5sxuPnWHIQS3kxCJwHaJ0?r=0&rs=1&pid=ImgDetMain&cb=idpwebp2&o=7&rm=3',
                    rating: 4.6,
                    reviews: 87
                },
                {
                    id: 6,
                    name: 'Cámara MirrorPro',
                    description: 'Cámara sin espejo con sensor full-frame de 24MP, grabación 4K y estabilización de 5 ejes.',
                    price: 1499.99,
                    oldPrice: 1899.99,
                    discount: 21,
                    image: 'https://cdn.pixabay.com/photo/2014/08/29/14/53/camera-431119_1280.jpg',
                    rating: 4.9,
                    reviews: 64
                },
                {
                    id: 7,
                    name: 'Altavoz Bluetooth SoundMax',
                    description: 'Altavoz portátil con sonido 360°, resistencia al agua IPX7 y 20 horas de batería.',
                    price: 129.99,
                    oldPrice: 179.99,
                    discount: 28,
                    image: 'https://th.bing.com/th/id/OIP.36losBJKCktLb-axjgay6wHaFj?r=0&rs=1&pid=ImgDetMain&cb=idpwebp2&o=7&rm=3',
                    rating: 4.4,
                    reviews: 109
                }
            ],
            isLoading: false,
            cart: {
                items: [],
                isOpen: false
            },
            productModal: {
                isOpen: false,
                product: {},
                quantity: 1
            },
            cartModal: {
                isOpen: false
            },
            profileModal: {
                isOpen: false,
                user: {
                    firstName: 'Juan',
                    lastName: 'Pérez',
                    email: 'juan.perez@example.com',
                    phone: '+123456789',
                    address: 'Calle Principal 123',
                    city: 'Ciudad',
                    state: 'Estado',
                    zipCode: '12345'
                }
            },
            ordersModal: {
                isOpen: false,
                orders: [
                    {
                        id: '10023',
                        date: '15/01/2025',
                        total: 1149.98,
                        status: 'Entregado',
                        items: [
                            {
                                id: 1,
                                name: 'Smartphone XYZ Pro',
                                price: 899.99,
                                quantity: 1,
                                image: 'https://cdn.pixabay.com/photo/2016/11/29/12/30/phone-1869510_1280.jpg'
                            },
                            {
                                id: 3,
                                name: 'Auriculares NoiseCancel',
                                price: 249.99,
                                quantity: 1,
                                image: 'https://cdn.pixabay.com/photo/2016/09/13/08/44/headphones-1666720_1280.jpg'
                            }
                        ]
                    },
                    {
                        id: '10022',
                        date: '02/01/2025',
                        total: 179.99,
                        status: 'En camino',
                        items: [
                            {
                                id: 4,
                                name: 'Smartwatch FitTrack',
                                price: 179.99,
                                quantity: 1,
                                image: 'https://cdn.pixabay.com/photo/2015/06/25/17/21/smart-watch-821557_1280.jpg'
                            }
                        ]
                    }
                ]
            },
            settingsModal: {
                isOpen: false,
                notifications: {
                    promotions: true,
                    orderUpdates: true,
                    newProducts: false
                },
                privacy: {
                    shareData: false,
                    thirdPartyCookies: true
                },
                password: {
                    current: '',
                    new: '',
                    confirm: ''
                }
            },
            toast: {
                show: false,
                message: '',
                type: 'success',
                timeout: null
            },
            countdown: {
                hours: '08',
                minutes: '45',
                seconds: '30'
            },
            
init() {
    // Inicializar Swiper para productos destacados
    this.$nextTick(() => {
        new Swiper('.productos-swiper', {
            slidesPerView: 'auto',
            spaceBetween: 20,
            loop: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
                pauseOnMouseEnter: true
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                },
                768: {
                    slidesPerView: 3,
                },
                1024: {
                    slidesPerView: 4,
                },
            }
        });
    });

    // Swiper para Productos Hogar - Configuración idéntica a productos destacados
    this.$nextTick(() => {
        new Swiper('.productos-hogar-swiper', {
            slidesPerView: 'auto',
            spaceBetween: 20,
            loop: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
                pauseOnMouseEnter: true
            },
            navigation: {
                nextEl: '.productos-hogar-next',
                prevEl: '.productos-hogar-prev',
            },
            pagination: {
                el: '.productos-hogar-pagination',
                clickable: true,
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                },
                768: {
                    slidesPerView: 3,
                },
                1024: {
                    slidesPerView: 4,
                }
            }
        });
    });
    


              
                // Load cart from localStorage
                const savedCart = localStorage.getItem('cart');
                if (savedCart) {
                    this.cart.items = JSON.parse(savedCart);
                }
                
                // Setup countdown timer
                this.startCountdown();
            },
            
            startCountdown() {
                let totalSeconds = parseInt(this.countdown.hours) * 3600 + 
                                   parseInt(this.countdown.minutes) * 60 + 
                                   parseInt(this.countdown.seconds);
                
                const countdownInterval = setInterval(() => {
                    totalSeconds--;
                    
                    if (totalSeconds <= 0) {
                        clearInterval(countdownInterval);
                        this.showToast('¡Las ofertas han terminado!', 'info');
                    }
                    
                    const hours = Math.floor(totalSeconds / 3600);
                    const minutes = Math.floor((totalSeconds % 3600) / 60);
                    const seconds = totalSeconds % 60;
                    
                    this.countdown.hours = hours.toString().padStart(2, '0');
                    this.countdown.minutes = minutes.toString().padStart(2, '0');
                    this.countdown.seconds = seconds.toString().padStart(2, '0');
                }, 1000);
            },
            
            fetchSuggestions() {
                setTimeout(() => {
                    const query = this.searchQuery.toLowerCase();
                    const allProducts = [...this.featuredProducts, ...this.dealProducts];
                    this.suggestions = allProducts.filter(p => 
                        p.name.toLowerCase().includes(query)
                    ).slice(0, 5);
                }, 300);
            },
            
            selectSuggestion(suggestion) {
                this.searchQuery = '';
                this.suggestions = [];
                this.openProductModal(suggestion);
            },
            
            selectCategory(category) {
                this.selectedCategory = category;
                this.showToast(`Categoría seleccionada: ${category.nombre}`, 'info');
            },
            
            openProductModal(product) {
                this.productModal.product = product;
                this.productModal.quantity = 1;
                this.productModal.isOpen = true;
            },
            
            incrementQuantity() {
                if (this.productModal.quantity < 99) {
                    this.productModal.quantity++;
                }
            },
            
            decrementQuantity() {
                if (this.productModal.quantity > 1) {
                    this.productModal.quantity--;
                }
            },
            
            addToCart(product, quantity) {
                this.isLoading = true;
                
                setTimeout(() => {
                    const existingItemIndex = this.cart.items.findIndex(item => item.id === product.id);
                    
                    if (existingItemIndex !== -1) {
                        this.cart.items[existingItemIndex].quantity += quantity;
                    } else {
                        this.cart.items.push({
                            id: product.id,
                            name: product.name,
                            price: product.price,
                            image: product.image,
                            quantity: quantity
                        });
                    }
                    
                    localStorage.setItem('cart', JSON.stringify(this.cart.items));
                    
                    this.isLoading = false;
                    this.productModal.isOpen = false;
                    this.showToast('Producto añadido al carrito', 'success');
                }, 800);
            },
            
            buyNow(product, quantity) {
                this.isLoading = true;
                
                setTimeout(() => {
                    this.addToCart(product, quantity);
                    this.toggleCart();
                }, 800);
            },
            
            toggleCart() {
                this.cartModal.isOpen = !this.cartModal.isOpen;
            },
            
            toggleProfileModal() {
                this.profileModal.isOpen = !this.profileModal.isOpen;
            },
            
            toggleOrdersModal() {
                this.ordersModal.isOpen = !this.ordersModal.isOpen;
            },
            
            toggleSettingsModal() {
                this.settingsModal.isOpen = !this.settingsModal.isOpen;
            },
            
            updateCartItem(index, quantity) {
                if (quantity <= 0) {
                    this.removeFromCart(index);
                } else {
                    this.cart.items[index].quantity = quantity;
                    localStorage.setItem('cart', JSON.stringify(this.cart.items));
                }
            },
            
            removeFromCart(index) {
                this.cart.items.splice(index, 1);
                localStorage.setItem('cart', JSON.stringify(this.cart.items));
                this.showToast('Producto eliminado del carrito', 'info');
            },
            
            calculateSubtotal() {
                return this.cart.items.reduce((total, item) => total + (item.price * item.quantity), 0);
            },
            
            checkout() {
                if (this.cart.items.length === 0) return;
                
                this.isLoading = true;
                
                setTimeout(() => {
                    this.isLoading = false;
                    this.cartModal.isOpen = false;
                    this.cart.items = [];
                    localStorage.removeItem('cart');
                    this.showToast('¡Pedido realizado con éxito!', 'success');
                }, 1500);
            },
            
            saveProfile() {
                this.isLoading = true;
                
                if (!this.profileModal.user.firstName || !this.profileModal.user.lastName || !this.profileModal.user.email) {
                    this.showToast('Por favor completa los campos obligatorios', 'error');
                    this.isLoading = false;
                    return;
                }
                
                setTimeout(() => {
                    this.isLoading = false;
                    this.profileModal.isOpen = false;
                    this.showToast('Perfil actualizado correctamente', 'success');
                }, 1000);
            },
            
            viewOrderDetails(order) {
                this.showToast('Ver detalles del pedido: ' + order.id, 'info');
            },
            
            changePassword() {
                this.isLoading = true;
                
                if (!this.settingsModal.password.current || !this.settingsModal.password.new || !this.settingsModal.password.confirm) {
                    this.showToast('Por favor completa todos los campos', 'error');
                    this.isLoading = false;
                    return;
                }
                
                if (this.settingsModal.password.new !== this.settingsModal.password.confirm) {
                    this.showToast('Las contraseñas no coinciden', 'error');
                    this.isLoading = false;
                    return;
                }
                
                setTimeout(() => {
                    this.isLoading = false;
                    this.settingsModal.password = { current: '', new: '', confirm: '' };
                    this.showToast('Contraseña actualizada correctamente', 'success');
                }, 1000);
            },
            
            logout() {
                this.isLoading = true;
                
                setTimeout(() => {
                    this.isLoading = false;
                    this.settingsModal.isOpen = false;
                    this.showToast('Sesión cerrada correctamente', 'success');
                }, 800);
            },
            
            showToast(message, type = 'success') {
                if (this.toast.timeout) {
                    clearTimeout(this.toast.timeout);
                }
                
                this.toast.message = message;
                this.toast.type = type;
                this.toast.show = true;
                
                this.toast.timeout = setTimeout(() => {
                    this.toast.show = false;
                }, 3000);
            }
        };
    }
</script>




    <style>
        /* Toggle Switch Styles */
        .toggle-checkbox:checked {
            right: 0;
            border-color:rgb(68, 68, 72);
        }
        .toggle-checkbox:checked + .toggle-label {
            background-color:rgb(129, 129, 132);
        }
        .toggle-checkbox {
            right: 0;
            z-index: 5;
            transition: all 0.3s;
        }
        .toggle-label {
            transition: all 0.3s;
        }
</style>

<script>
    function toggleDropdown() {
        const dropdown = document.getElementById('dropdownCarrito');
        dropdown.classList.toggle('hidden');
    }

    window.addEventListener('click', function(e) {
        const dropdown = document.getElementById('dropdownCarrito');
        if (!e.target.closest('#dropdownCarrito') && !e.target.closest('button[onclick="toggleDropdown()"]')) {
            dropdown.classList.add('hidden');
        }
    });
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('input[name="_token"]').value;
    
    // Función para actualizar el dropdown del carrito
    function updateCartDropdown(data) {
        // Actualizar contador
        const cartCount = data.cart_count || 0;
        const cartCountElement = document.querySelector('.fa-shopping-cart').nextElementSibling;
        
        if (cartCount > 0) {
            if (cartCountElement) {
                cartCountElement.textContent = cartCount;
            } else {
                const cartIcon = document.querySelector('.fa-shopping-cart');
                const countBadge = document.createElement('span');
                countBadge.className = 'absolute -top-2 -right-2 bg-red-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center';
                countBadge.textContent = cartCount;
                cartIcon.parentNode.appendChild(countBadge);
            }
        } else if (cartCountElement) {
            cartCountElement.remove();
        }
        
        // Actualizar contenido del dropdown
        fetch('/carrito/dropdown-content')
            .then(response => response.text())
            .then(html => {
                document.getElementById('cart-dropdown').innerHTML = html;
                setupCartEvents();
            });
        
       
    }
    
    // Configurar eventos del carrito
    function setupCartEvents() {
        // Eventos para eliminar items
        document.querySelectorAll('.delete-item').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const productId = this.getAttribute('data-id');
                removeFromCart(productId);
            });
        });
    }
    
    // Función para eliminar items
    function removeFromCart(productId) {
        fetch(`/carrito/eliminar/${productId}`, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateCartDropdown(data);
            }
        });
    }
    
    // Manejar agregar al carrito
    document.querySelectorAll('.add-to-cart-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const button = this.querySelector('button[type="submit"]');
            const originalText = button.innerHTML;
            
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Añadiendo...';
            button.disabled = true;
            
            fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: new FormData(this)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateCartDropdown(data);
                }
            })
            .finally(() => {
                button.innerHTML = originalText;
                button.disabled = false;
            });
        });
    });
    
    // Configurar eventos iniciales
    setupCartEvents();
});
</script>


<!--Script productos hogar-->
<script>
document.addEventListener('DOMContentLoaded', function() {
    new Swiper('.productos-hogar-swiper', {
        slidesPerView: 'auto',
        spaceBetween: 20,
        navigation: {
            nextEl: '.productos-hogar-next',
            prevEl: '.productos-hogar-prev',
        },
    });
    
});


</script>
    <script src="{{ asset('js/dropdown-cart.js') }}"></script>
<style>
/* Estilos para los botones de navegación */
.productos-hogar-next, .productos-destacados-prev, .productos-hogar-prev, .productos-destacados-next {
    color: #4b5563 !important; /* text-gray-700 */
    background: white !important;
    width: 40px !important;
    height: 40px !important;
    border-radius: 50% !important;
    box-shadow: 0 0px 5px black!important;
    
}

.productos-hogar-next::after, .productos-destacados-next::after, .productos-hogar-prev::after, .productos-destacados-prev::after {
    font-size: 16px !important;
    font-weight: bold !important;
   
}

/* Estilos para la paginación */
.productos-hogar-pagination .swiper-pagination-bullet {
    background: #6b7280; /* text-gray-500 */
    opacity: 0.5;
}

.productos-hogar-pagination .swiper-pagination-bullet-active {
    background: #4b5563; /* text-gray-600 */
    opacity: 1;
}
</style>

</body>
</html>

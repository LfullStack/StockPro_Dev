<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <style>
            /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */
            html{line-height:1.15;-webkit-text-size-adjust:100%}
            body{margin:0}
            a{background-color:transparent}
            [hidden]{display:none}
            html{font-family:'Nunito', sans-serif;line-height:1.6}
            body{font-family:'Nunito', sans-serif}
            .antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}
            .relative{position:relative}
            .flex{display:flex}
            .items-top{align-items:flex-start}
            .justify-center{justify-content:center}
            .min-h-screen{min-height:100vh}
            .bg-gray-100{background-color:#f7fafc}
            .dark .bg-gray-900{background-color:#1a202c}
            .sm\:items-center{align-items:center}
            .sm\:pt-0{padding-top:0}
            .fixed{position:fixed}
            .top-0{top:0}
            .right-0{right:0}
            .px-6{padding-left:1.5rem;padding-right:1.5rem}
            .py-4{padding-top:1rem;padding-bottom:1rem}
            .text-sm{font-size:.875rem}
            .text-gray-700{color:#4a5568}
            .dark .text-gray-500{color:#a0aec0}
            .underline{text-decoration:underline}
            .ml-4{margin-left:1rem}
            .mt-2{margin-top:.5rem}
            .text-gray-600{color:#718096}
            .dark .text-gray-400{color:#cbd5e0}
            .text-center{text-align:center}
        </style>
    </head>
    <body class="antialiased bg-gray-100 dark:bg-gray-900">
        <div class="relative flex items-top justify-center min-h-screen sm:items-center sm:pt-0">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="text-center mt-2 text-gray-600 dark:text-gray-400 text-sm">
                    Laravel {{ Illuminate\Foundation\Application::VERSION }} (PHP {{ PHP_VERSION }})
                    
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
                        <button @click="toggleCart()" class="relative">
                            <i class="fas fa-shopping-cart text-xl"></i>
                            <span x-show="cart.items.length > 0" 
                                  x-text="cart.items.length" 
                                  class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                            </span>
                        </button>
                        <button @click="toggleProfileModal()">
                            <i class="fas fa-user-circle text-xl"></i>
                        </button>
                        <button @click="toggleOrdersModal()">
                            <i class="fas fa-clipboard-list text-xl"></i>
                        </button>
                        <button @click="toggleSettingsModal()">
                            <i class="fas fa-cog text-xl"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Categories menu -->
                <div class="pt-2 pb-1 overflow-x-auto whitespace-nowrap hide-scrollbar">
                    <template x-for="category in categories" :key="category.id">
                        <a href="javascript:void(0)" 
                           @click="selectCategory(category)"
                           class="px-4 py-1 mr-2 text-sm rounded-full hover:bg-white hover:text-indigo-600 transition-colors"
                           :class="selectedCategory && selectedCategory.id === category.id ? 'bg-white text-indigo-600' : ''">
                            <span x-text="category.name"></span>
                        </a>
                    </template>
                </div>
            </div>
        </nav>
        
        <!-- Main content -->
        <main class="flex-grow">
            <!-- Hero Banner Carousel -->
            <div class="swiper banner-swiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide bg-gradient-to-r from-blue-500 to-indigo-700">
                        <div class="container mx-auto px-6 flex items-center justify-between">
                            <div class="text-white max-w-md">
                                <h2 class="text-4xl font-bold mb-4">Nuevos Auriculares Bluetooth</h2>
                                <p class="mb-6">Sonido inigualable con 30 horas de batería</p>
                                <button class="bg-white text-indigo-600 px-6 py-2 rounded-lg font-semibold hover:bg-opacity-90 transition">Ver oferta</button>
                            </div>
                            <img src="https://cdn.pixabay.com/photo/2018/01/16/10/18/headphones-3085681_1280.jpg" alt="Auriculares" class="h-56 object-contain">
                        </div>
                    </div>
                    <div class="swiper-slide bg-gradient-to-r from-pink-500 to-purple-700">
                        <div class="container mx-auto px-6 flex items-center justify-between">
                            <div class="text-white max-w-md">
                                <h2 class="text-4xl font-bold mb-4">Smartwatches en oferta</h2>
                                <p class="mb-6">Hasta 40% de descuento en modelos seleccionados</p>
                                <button class="bg-white text-purple-600 px-6 py-2 rounded-lg font-semibold hover:bg-opacity-90 transition">Comprar ahora</button>
                            </div>
                            <img src="https://cdn.pixabay.com/photo/2015/06/25/17/21/smart-watch-821557_1280.jpg" alt="Smartwatch" class="h-56 object-contain">
                        </div>
                    </div>
                    <div class="swiper-slide bg-gradient-to-r from-amber-500 to-red-600">
                        <div class="container mx-auto px-6 flex items-center justify-between">
                            <div class="text-white max-w-md">
                                <h2 class="text-4xl font-bold mb-4">Nuevas Laptops Gaming</h2>
                                <p class="mb-6">Potencia y rendimiento a otro nivel</p>
                                <button class="bg-white text-red-600 px-6 py-2 rounded-lg font-semibold hover:bg-opacity-90 transition">Explorar</button>
                            </div>
                            <img src="https://cdn.pixabay.com/photo/2016/03/27/07/12/apple-1282241_1280.jpg" alt="Laptop" class="h-56 object-contain">
                        </div>
                    </div>
                </div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-next text-white"></div>
                <div class="swiper-button-prev text-white"></div>
            </div>
            
            <!-- Featured Categories -->
            <section class="py-8 bg-white">
                <div class="container mx-auto px-4">
                    <h2 class="text-2xl font-bold mb-6">Categorías Destacadas</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <a href="javascript:void(0)" class="group">
                            <div class="bg-gray-100 rounded-lg p-4 text-center transition-all group-hover:bg-indigo-50 group-hover:shadow-md">
                                <div class="w-16 h-16 mx-auto mb-3 bg-indigo-100 rounded-full flex items-center justify-center group-hover:bg-indigo-200">
                                    <i class="fas fa-mobile-alt text-indigo-600 text-2xl"></i>
                                </div>
                                <h3 class="font-semibold text-gray-800">Smartphones</h3>
                            </div>
                        </a>
                        <a href="javascript:void(0)" class="group">
                            <div class="bg-gray-100 rounded-lg p-4 text-center transition-all group-hover:bg-indigo-50 group-hover:shadow-md">
                                <div class="w-16 h-16 mx-auto mb-3 bg-indigo-100 rounded-full flex items-center justify-center group-hover:bg-indigo-200">
                                    <i class="fas fa-laptop text-indigo-600 text-2xl"></i>
                                </div>
                                <h3 class="font-semibold text-gray-800">Laptops</h3>
                            </div>
                        </a>
                        <a href="javascript:void(0)" class="group">
                            <div class="bg-gray-100 rounded-lg p-4 text-center transition-all group-hover:bg-indigo-50 group-hover:shadow-md">
                                <div class="w-16 h-16 mx-auto mb-3 bg-indigo-100 rounded-full flex items-center justify-center group-hover:bg-indigo-200">
                                    <i class="fas fa-headphones text-indigo-600 text-2xl"></i>
                                </div>
                                <h3 class="font-semibold text-gray-800">Audio</h3>
                            </div>
                        </a>
                        <a href="javascript:void(0)" class="group">
                            <div class="bg-gray-100 rounded-lg p-4 text-center transition-all group-hover:bg-indigo-50 group-hover:shadow-md">
                                <div class="w-16 h-16 mx-auto mb-3 bg-indigo-100 rounded-full flex items-center justify-center group-hover:bg-indigo-200">
                                    <i class="fas fa-gamepad text-indigo-600 text-2xl"></i>
                                </div>
                                <h3 class="font-semibold text-gray-800">Gaming</h3>
                            </div>
                        </a>
                    </div>
                </div>
            </section>
            
            <!-- Featured Products -->
            <section class="py-8">
                <div class="container mx-auto px-4">
                    <h2 class="text-2xl font-bold mb-6">Productos Destacados</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        <template x-for="product in featuredProducts" :key="product.id">
                            <div class="bg-white rounded-lg shadow-md overflow-hidden product-card">
                                <img :src="product.image" :alt="product.name" class="w-full h-48 object-cover">
                                <div class="p-4">
                                    <h3 class="font-semibold text-lg mb-2" x-text="product.name"></h3>
                                    <div class="flex items-center mb-2">
                                        <div class="flex text-amber-400">
                                            <template x-for="i in 5">
                                                <i class="fas fa-star" :class="i <= product.rating ? 'text-amber-400' : 'text-gray-300'"></i>
                                            </template>
                                        </div>
                                        <span class="text-gray-600 text-sm ml-2" x-text="product.reviews + ' reseñas'"></span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <span class="text-lg font-bold text-indigo-600" x-text="'$' + product.price.toFixed(2)"></span>
                                            <span x-show="product.oldPrice" class="text-sm text-gray-500 line-through ml-2" x-text="'$' + product.oldPrice.toFixed(2)"></span>
                                        </div>
                                        <button @click="openProductModal(product)" 
                                                class="bg-indigo-600 text-white p-2 rounded-full hover:bg-indigo-700">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </section>
            
            <!-- Daily Deals -->
            <section class="py-8 bg-gradient-to-r from-pink-500 to-purple-600 text-white">
                <div class="container mx-auto px-4">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold">Ofertas del Día</h2>
                        <div class="text-white">
                            <span class="countdown-text">Termina en: </span>
                            <span class="font-mono" x-text="countdown.hours">00</span>:
                            <span class="font-mono" x-text="countdown.minutes">00</span>:
                            <span class="font-mono" x-text="countdown.seconds">00</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <template x-for="product in dealProducts" :key="product.id">
                            <div class="bg-white rounded-lg shadow-lg overflow-hidden text-gray-800 product-card">
                                <div class="relative">
                                    <img :src="product.image" :alt="product.name" class="w-full h-48 object-cover">
                                    <div class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">
                                        <span x-text="'-' + product.discount + '%'"></span>
                                    </div>
                                </div>
                                <div class="p-4">
                                    <h3 class="font-semibold text-lg mb-2" x-text="product.name"></h3>
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <span class="text-lg font-bold text-indigo-600" x-text="'$' + product.price.toFixed(2)"></span>
                                            <span class="text-sm text-gray-500 line-through ml-2" x-text="'$' + product.oldPrice.toFixed(2)"></span>
                                        </div>
                                        <button @click="openProductModal(product)" 
                                                class="bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700">
                                            Ver oferta
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </section>
        </main>
        
        <!-- Footer -->
        <footer class="bg-gray-800 text-white py-8">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div>
                        <h3 class="text-xl font-bold mb-4">TechShop</h3>
                        <p class="text-gray-400">La mejor tienda de tecnología para todos tus dispositivos.</p>
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
                            <li><a href="javascript:void(0)" class="text-gray-400 hover:text-white">Inicio</a></li>
                            <li><a href="javascript:void(0)" class="text-gray-400 hover:text-white">Productos</a></li>
                            <li><a href="javascript:void(0)" class="text-gray-400 hover:text-white">Ofertas</a></li>
                            <li><a href="javascript:void(0)" class="text-gray-400 hover:text-white">Contacto</a></li>
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
                <div class="border-t border-gray-700 mt-8 pt-6 text-center text-gray-400">
                    <a href="{{ route('inicio.index') }}">&copy; 2025 TechShop. Todos los derechos reservados.</a>
                </div>
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
    </body>
</html>

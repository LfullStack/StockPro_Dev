@if(count($carrito))
    <div class="p-3 max-h-64 overflow-y-auto divide-y divide-gray-200">
        @foreach($carrito as $id => $item)
            <div class="flex items-center space-x-3 py-3">
                <img src="{{ $item['foto'] }}" class="w-12 h-12 object-contain rounded" alt="producto">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate">{{ $item['nombre'] }}</p>
                    <p class="text-xs text-gray-500">Cantidad: {{ $item['cantidad'] }} × ${{ number_format($item['precio'], 0, ',', '.') }}</p>
                    <p class="text-xs font-semibold text-gray-700 mt-1">${{ number_format($item['precio'] * $item['cantidad'], 0, ',', '.') }}</p>
                </div>
                <button class="text-red-600 hover:text-red-800 text-lg delete-item" data-id="{{ $id }}" title="Eliminar">🗑️</button>
            </div>
        @endforeach
    </div>
    <div class="border-t border-gray-200 px-4 py-3 bg-gray-50">
        <a href="{{ route('carrito') }}" class="block text-center bg-gray-600 hover:bg-gray-700 text-white py-2 px-4 rounded-md text-sm font-medium transition duration-150">
            Ver carrito completo
        </a>
    </div>
@else
    <div class="p-4 text-center">
        <i class="fas fa-shopping-basket text-3xl text-gray-300 mb-2"></i>
        <p class="text-gray-500">Tu carrito está vacío</p>
        <p class="text-xs text-gray-400 mt-1">Agrega productos para comenzar</p>
    </div>
@endif
<x-layouts.app :title="__('Dashboard | StockPro')">
    <div >
        <flux:breadcrumbs>

            <flux:breadcrumbs.item >Dashboard</flux:breadcrumbs.item>

        </flux:breadcrumbs>
    </div>
    {{-- Alertas de productos bajos --}}
    @if($productosBajos->count())
    <div 
        x-data="{ show: true }"
        x-show="show"
        x-transition
        class="mt-8 p-4 bg-red-50 dark:bg-red-900/40 border border-red-300 dark:border-red-700 rounded-xl shadow-sm relative"
    >
        <button 
            @click="show = false"
            class="absolute top-2 right-2 text-red-700 dark:text-red-300 hover:text-red-900 dark:hover:text-white"
        >
            &times;
        </button>

        <h2 class="text-lg font-semibold text-red-800 dark:text-red-200 ">
            ⚠ Productos con bajo inventario
        </h2>
        <ul class="list-disc pl-5 mt-2 text-red-700 dark:text-red-300 space-y-1">
            @foreach($productosBajos as $producto)
                <li>
                    <span class="font-medium">{{ $producto->nombre }}</span>: solo quedan <strong>{{ $producto->cantidad }}</strong> unidades.
                </li>
            @endforeach
        </ul>
    </div>
    @endif
    
        {{-- Notificaciones de actividades --}}
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mt-6">
        <div class="rounded-xl bg-white dark:bg-neutral-900 p-4 shadow-md flex items-center justify-between">
            <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Inventario</p>
                    <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $totalInventario }}</p>
                </div>
                <svg class="w-8 h-8 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
            <path d="M4 3a1 1 0 011-1h10a1 1 0 011 1v2H4V3zm0 4h12v10a1 1 0 01-1 1H5a1 1 0 01-1-1V7z"/>
        </svg>
            
        </div>

        <div class="rounded-xl bg-white dark:bg-neutral-900 p-4 shadow-md flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Total Facturas</p>
                <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $totalFacturas }}</p>
            </div>
            <svg class="w-8 h-8 text-green-500" fill="currentColor" viewBox="0 0 20 20">
            <path d="M6 2a1 1 0 00-1 1v14a1 1 0 001.447.894l5.106-2.553A1 1 0 0013 14.447V3a1 1 0 00-1-1H6z"/>
        </svg>
        </div>

        <div class="rounded-xl bg-white dark:bg-neutral-900 p-4 shadow-md flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Usuarios Registrados</p>
                <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $totalUsuarios }}</p>
            </div>
            <svg class="w-8 h-8 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 4a3 3 0 110 6 3 3 0 010-6zm-6 9a6 6 0 1112 0v1a1 1 0 01-1 1H5a1 1 0 01-1-1v-1z" clip-rule="evenodd"/>
        </svg>
        </div>

        <div class="rounded-xl bg-white dark:bg-neutral-900 p-4 shadow-md flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Productos Registrados</p>
                <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $totalProductos }}</p>
            </div>
            <svg class="w-8 h-8 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
            <path d="M2.003 5.884L10 1l7.997 4.884v8.232L10 19l-7.997-4.884V5.884zM10 3.618L4.33 7 10 10.382 15.67 7 10 3.618z"/>
        </svg>
        </div>

    </div>

    <div class="rounded-xl bg-white dark:bg-neutral-900 p-4 shadow-md mt-8">
        <div class="flex justify-between items-center mb-2">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Meta de Ventas (Mensual)</p>
                <p class="text-xl font-bold text-gray-900 dark:text-white">
                    ${{ number_format($ventasDelMes, 0) }} / ${{ number_format($metaMonto, 0) }}
                </p>
            </div>
            <span class="text-sm font-semibold text-gray-500 dark:text-gray-300">
                {{ number_format($porcentaje, 0) }}%
            </span>
        </div>

        <div class="w-full h-4 bg-gray-200 dark:bg-neutral-700 rounded-full overflow-hidden">
            <div 
                class="h-full rounded-full transition-all duration-500"
                style="
                    width: {{ min($porcentaje, 100) }}%;
                    background-color:
                        {{ $porcentaje < 50 ? '#ef4444' : ($porcentaje < 80 ? '#facc15' : '#10b981') }};
                "
            ></div>
        </div>
    </div>



<div class="rounded-xl border border-gray-200 bg-white p-4 shadow-md dark:border-neutral-800 dark:bg-neutral-900 mt-8">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-white">
            Últimos Eventos del Sistema
        </h2>
        <a href="{{ route('admin.eventos.index') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
            Ver todos
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 ">
        @forelse ($ultimosEventos as $evento)
            @php
                $estilos = [
                    'success' => ['text' => 'text-green-600 dark:text-green-400', 'icon' => '✅'],
                    'warning' => ['text' => 'text-yellow-600 dark:text-yellow-400', 'icon' => '⚠️'],
                    'danger'  => ['text' => 'text-red-600 dark:text-red-400', 'icon' => '❌'],
                    'info'    => ['text' => 'text-blue-600 dark:text-blue-400', 'icon' => 'ℹ️'],
                    'default' => ['text' => 'text-gray-600 dark:text-gray-400', 'icon' => '🔔'],
                ];

                $tipo = $evento->tipo ?? 'default';
                $colorTexto = $estilos[$tipo]['text'] ?? $estilos['default']['text'];
                $icono = $estilos[$tipo]['icon'] ?? $estilos['default']['icon'];
            @endphp

            <a href="{{ route('admin.eventos.index') }}"
                class="flex items-start space-x-3 p-4 rounded-xl hover:bg-gray-50 dark:hover:bg-neutral-800 transition border border-gray-100 dark:border-neutral-800">
                <div class="text-2xl">{{ $icono }}</div>
                <div class="text-sm text-gray-700 dark:text-gray-300">
                <span class="font-semibold {{ $colorTexto }}">
                    {{ ucfirst($evento->titulo ?? 'Acción desconocida') }}
                </span>

                    — {{ $evento->descripcion }}
                    <br>
                    <span class="text-xs text-gray-500 dark:text-gray-400">
                        {{ $evento->user?->name ?? 'Sistema' }} | {{ $evento->created_at->format('d/m/Y H:i') }}
                    </span>
                </div>
            </a>
        @empty
            <p class="text-sm text-gray-500 dark:text-gray-400">No hay eventos recientes.</p>
        @endforelse
    </div>
</div>





    @php
        $meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
        $labelsMeses = $ventasPorMes->pluck('mes')->map(fn($m) => $meses[$m - 1]);
        $totalesMeses = $ventasPorMes->pluck('total');

        $labelsProductos = $productosMasVendidos->map(fn($item) => optional($item->producto)->nombre ?? 'Desconocido');
        $cantidadVendida = $productosMasVendidos->pluck('total_vendida');
    @endphp

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 mt-8 justify-between">

        {{-- Gráfico de ventas mensuales --}}
        
        <div class="rounded-xl bg-white p-4 shadow-md dark:bg-neutral-900 dark:text-white">
            <h2 class="mb-2 text-lg font-semibold">Ventas Mensuales</h2>
            <canvas id="ventasChart" height="250"></canvas>
            
            <div class="rounded-xl bg-white dark:bg-neutral-900 p-4 shadow-md flex items-center justify-between">
            <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Ventas hoy</p>
                    <p class="text-xl font-bold text-gray-900 dark:text-white">$ {{ number_format($totalVentasHoy, 2) }}</p>
                </div>
                <svg class="w-10 h-10 text-green-500" fill="currentColor" viewBox="0 0 20 20">
        <path d="M4 2a1 1 0 00-1 1v14l2-1 2 1 2-1 2 1 2-1 2 1V3a1 1 0 00-1-1H4zm2 4h8a1 1 0 100-2H6a1 1 0 100 2zm0 3h8a1 1 0 100-2H6a1 1 0 100 2zm0 3h5a1 1 0 100-2H6a1 1 0 100 2z"/>
    </svg>
    <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Ventas Semana</p>
                    <p class="text-xl font-bold text-gray-900 dark:text-white">$ {{ number_format($totalVentasSemana, 2) }}</p>
                </div>
                <svg class="w-10 h-10 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                <path d="M3 3h2v14H3V3zm4 4h2v10H7V7zm4 3h2v7h-2v-7zm4-5h2v12h-2V5z"/>
            </svg>
            

            
        </div>
        </div>

        {{-- Gráfico de productos más vendidos --}}
        <div class="rounded-xl bg-white p-4 shadow-md dark:bg-neutral-900 dark:text-white">
            <h2 class="mb-2 text-lg font-semibold">Productos Más Vendidos</h2>
            <canvas id="productosChart" height="50" style="height: 50px;"></canvas>
            
        </div>

    </div>


    <div x-data="{ open: false, post: {} }" class="mt-8 w-full">
    <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">📝 Últimos Posts Publicados</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
        @foreach($posts->take(3) as $post)
            <div 
                @click="post = {{ $post->toJson() }}; open = true"
                class="cursor-pointer rounded-xl bg-white dark:bg-neutral-900 shadow-md p-4 hover:ring-2 hover:ring-green-400 transition"
            >
                <h3 class="text-lg font-bold text-green-600 dark:text-green-400">{{ $post->titulo }}</h3>
                <p class="mt-1 text-gray-700 dark:text-gray-300 text-sm line-clamp-3">{{ $post->asunto }}</p>
                <div class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                    Publicado por <strong>{{ $post->user->name }}</strong> - {{ $post->created_at->diffForHumans() }}
                </div>
            </div>
        @endforeach
    </div>

    <!-- Modal -->


    {{-- Últimas facturas generadas Clientes y Proveedores --}}
    <div class="mt-8 bg-white dark:bg-neutral-900 rounded-xl shadow-md overflow-hidden">
        <div class="p-4 border-b border-gray-200 dark:border-neutral-700">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white">🧾 Últimas Facturas Generadas Clientes</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-100 dark:bg-neutral-800 text-gray-700 dark:text-neutral-300">
                    <tr>
                        <th class="px-4 py-2">#</th>
                        <th class="px-4 py-2">Cliente</th>
                        <th class="px-4 py-2">Total</th>
                        <th class="px-4 py-2">Fecha</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-neutral-900 divide-y divide-gray-200 dark:divide-neutral-700">
                    @foreach($ultimasFacturas as $factura)
                        <tr>
                            <td class="px-4 py-2">{{ $factura->id }}</td>
                            <td class="px-4 py-2">{{ $factura->cliente->name ?? 'Cliente N/D' }}</td>
                            <td class="px-4 py-2 font-semibold">${{ number_format($factura->total, 2) }}</td>
                            <td class="px-4 py-2">{{ $factura->created_at->format('d/m/Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-8 bg-white dark:bg-neutral-900 rounded-xl shadow-md overflow-hidden">
        <div class="p-4 border-b border-gray-200 dark:border-neutral-700">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white">🧾 Últimas Facturas Generadas de Proveedores</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-100 dark:bg-neutral-800 text-gray-700 dark:text-neutral-300">
                    <tr>
                        <th class="px-4 py-2">#</th>
                        <th class="px-4 py-2">Proveedor</th>
                        <th class="px-4 py-2">Total</th>
                        <th class="px-4 py-2">Fecha</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-neutral-900 divide-y divide-gray-200 dark:divide-neutral-700">
                    @foreach($ultimasFacturasProveedores as $factura)
                        <tr>
                            <td class="px-4 py-2">{{ $factura->id }}</td>
                            <td class="px-4 py-2">{{ $factura->proveedor->nombre ?? 'Proveedor N/D' }}</td>
                            <td class="px-4 py-2 font-semibold">${{ number_format($factura->total, 2) }}</td>
                            <td class="px-4 py-2">{{ $factura->created_at->format('d/m/Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function isDarkMode() {
            return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
        }

        const labelColor = isDarkMode() ? '#fff' : '#000';
        const gridColor = isDarkMode() ? '#444' : '#ccc';

        // Gráfico de ventas por mes
        new Chart(document.getElementById('ventasChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($labelsMeses) !!},
                datasets: [{
                    label: 'Ventas ($)',
                    data: {!! json_encode($totalesMeses) !!},
                    backgroundColor: '#4f46e5',
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: { ticks: { color: labelColor }, grid: { color: gridColor } },
                    y: { beginAtZero: true, ticks: { color: labelColor }, grid: { color: gridColor } }
                }
            }
        });

        // Gráfico de productos más vendidos
        new Chart(document.getElementById('productosChart').getContext('2d'), {
            type: 'pie',
            data: {
                labels: {!! json_encode($labelsProductos) !!},
                datasets: [{
                    label: 'Cantidad vendida',
                    data: {!! json_encode($cantidadVendida) !!},
                    backgroundColor: ['#4f46e5','#10b981','#f59e0b','#ef4444','#6366f1']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        labels: { color: labelColor }
                    }
                }
            }
        });
    </script>
</x-layouts.app>

<div>
    <div class="space-y-4">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-white">🔔 Notificaciones recientes</h2>

        @forelse($eventos as $evento)
            @php
                switch ($evento->tipo) {
                    case 'success':
                        $bg = 'bg-green-100 dark:bg-green-900/40';
                        $icon = 'check-circle';
                        $color = 'text-green-600 dark:text-green-300';
                        break;
                    case 'warning':
                        $bg = 'bg-yellow-100 dark:bg-yellow-900/40';
                        $icon = 'alert-triangle';
                        $color = 'text-yellow-600 dark:text-yellow-300';
                        break;
                    case 'error':
                        $bg = 'bg-red-100 dark:bg-red-900/40';
                        $icon = 'x-circle';
                        $color = 'text-red-600 dark:text-red-300';
                        break;
                    default:
                        $bg = 'bg-blue-100 dark:bg-blue-900/40';
                        $icon = 'info';
                        $color = 'text-blue-600 dark:text-blue-300';
                        break;
                }
            @endphp

            <div class="flex gap-4 p-4 rounded-xl shadow-md border dark:border-neutral-700 {{ $bg }}">
                {{-- Icono --}}
                <div class="pt-1">
                    @if($icon === 'check-circle')
                        <svg class="w-6 h-6 {{ $color }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2l4 -4m-7 4a7 7 0 1 1 14 0a7 7 0 0 1 -14 0z" />
                        </svg>
                    @elseif($icon === 'alert-triangle')
                        <svg class="w-6 h-6 {{ $color }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.29 3.86L1.82 18a1.5 1.5 0 001.29 2.25h17.78a1.5 1.5 0 001.29-2.25L13.71 3.86a1.5 1.5 0 00-2.42 0zM12 9v4m0 4h.01"/>
                        </svg>
                    @elseif($icon === 'x-circle')
                        <svg class="w-6 h-6 {{ $color }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    @else
                        <svg class="w-6 h-6 {{ $color }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z"/>
                        </svg>
                    @endif
                </div>

                {{-- Contenido --}}
                <div class="flex-1">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white">{{ $evento->titulo }}</h3>
                    @if($evento->descripcion)
                        <p class="text-sm text-gray-600 dark:text-gray-300">{{ $evento->descripcion }}</p>
                    @endif
                    <p class="text-xs mt-1 text-gray-500 dark:text-gray-400">
                        Por <strong>{{ $evento->user->name ?? 'Usuario desconocido' }}</strong> —
                        {{ $evento->created_at->format('d/m/Y H:i') }}
                    </p>
                </div>
            </div>
        @empty
            <p class="text-gray-500 dark:text-gray-400 text-sm">No hay eventos registrados.</p>
        @endforelse

        @if($eventos->count() >= $limite)
            <button wire:click="loadMore"
                class="mt-4 w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm">
                Cargar más
            </button>
        @endif
    </div>

</div>
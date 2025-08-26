<x-layouts.app :title="'Ver Posts | StockPro'">

    <div class="mb-8 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Posts</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <x-button-crear href="{{ route('admin.posts.create') }}">Nuevo</x-button-crear>
    </div>

    @php
        $colores = [
            'red' => 'text-red-600 dark:text-red-400 border-red-300 dark:border-red-500',
            'blue' => 'text-blue-600 dark:text-blue-400 border-blue-300 dark:border-blue-500',
            'green' => 'text-green-600 dark:text-green-400 border-green-300 dark:border-green-500',
            'yellow' => 'text-yellow-600 dark:text-yellow-400 border-yellow-300 dark:border-yellow-500',
            'purple' => 'text-purple-600 dark:text-purple-400 border-purple-300 dark:border-purple-500',
            'pink' => 'text-pink-600 dark:text-pink-400 border-pink-300 dark:border-pink-500',
            'cyan' => 'text-cyan-600 dark:text-cyan-400 border-cyan-300 dark:border-cyan-500',
            'indigo' => 'text-indigo-600 dark:text-indigo-400 border-indigo-300 dark:border-indigo-500',
        ];
        $colorKeys = array_keys($colores);
    @endphp

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @forelse ($posts as $post)
            @php
                $colorIndex = $post->user_id % count($colorKeys);
                $colorName = $colorKeys[$colorIndex];
                $colorClasses = $colores[$colorName];
            @endphp

            <div class="rounded-xl bg-white dark:bg-neutral-900 shadow-md p-4 flex flex-col justify-between h-full border {{ $colorClasses }}">
                <div>
                    <h3 class="text-lg font-bold {{ $colorClasses }}">{{ $post->titulo }}</h3>
                    <p class="text-sm mt-1 font-medium {{ $colorClasses }}">{{ $post->asunto }}</p>
                    <p class="mt-2 text-gray-800 dark:text-gray-100 text-sm line-clamp-3">
                        {{ $post->contenido }}
                    </p>
                </div>

                <div class="mt-4 text-xs text-gray-500 dark:text-gray-400">
                    <p>Publicado por <strong>{{ $post->user?->name ?? 'Sin autor' }}</strong></p>
                    <p>Creado: {{ $post->created_at->format('d M Y H:i') }}</p>
                    <p>Actualizado: {{ $post->updated_at->format('d M Y H:i') }}</p>
                </div>

                <div class="flex justify-end gap-2 mt-4">
                    @php
                        $user = auth()->user();
                        $puedeEditar = $post->user_id === $user->id || $user->hasRole('admin');
                    @endphp

                    @if($puedeEditar)
                        <x-button-link href="{{ route('admin.posts.edit', $post) }}" size="sm">
                            Editar
                        </x-button-link>
                    @endif


                    @php
                        $user = auth()->user();
                        $puedeEliminar = $post->user_id === $user->id || $user->hasRole('admin');
                    @endphp

                    @if($puedeEliminar)
                        <form class="confirmar-eliminar" action="{{ route('admin.posts.destroy', $post->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <x-button type="submit">Eliminar</x-button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full text-center text-gray-500 dark:text-gray-400">
                No hay posts registrados aún.
            </div>
        @endforelse
    </div>

    @include('components.scripts.datatable-delete')

</x-layouts.app>

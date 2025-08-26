<x-layouts.app :title="'Editar Post | StockPro'">
    <flux:breadcrumbs class="mb-8">
        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('admin.posts.index')">Posts</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>Editar</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="max-w-5xl mx-auto p-6 bg-white rounded shadow dark:bg-zinc-800">
        <form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Titulo --}}
                <x-input-text
                    name="titulo"
                    label="Titulo"
                    :value="old('titulo', $post->titulo)"
                    required
                />

                {{-- Asunto --}}
                <x-input-text
                    name="asunto"
                    label="Asunto"
                    :value="old('asunto', $post->asunto)"
                    required
                />

                {{-- Contenido --}}
                <div class="md:col-span-2">
                    <label for="contenido" class="form-label">Contenido</label>
                    <textarea
                        name="contenido"
                        id="contenido"
                        rows="4"
                        class="form-input w-full"
                    >{{ old('contenido', $post->contenido) }}</textarea>
                    @error('contenido')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Botones -->
            <div class="flex justify-end space-x-2 mt-4">
                <x-button-link href="{{ route('admin.posts.index') }}">Cancelar</x-button-link>
                <x-button type="submit">Actualizar</x-button>
            </div>
        </form>
    </div>
</x-layouts.app>

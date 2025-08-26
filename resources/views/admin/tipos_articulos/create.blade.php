<x-layouts.app :title="'Crear Tipo de Artículo |StockPro'">

    <flux:breadcrumbs class="mb-8">
        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('admin.tipos_articulos.index')">Tipos de Artículo</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>Nuevo</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="max-w-xl mx-auto p-6 bg-white rounded shadow dark:bg-zinc-800">
        @if ($categorias->isEmpty())
            <div class="p-4 mb-4 text-red-700 bg-red-100 rounded">
                No hay categorías registradas. Debes crear al menos una categoría antes de agregar un tipo de artículo.
            </div>
        @endif

        <form method="POST" action="{{ route('admin.tipos_articulos.store') }}">
            @csrf

            {{-- Nombre --}}
            <x-input-text
                name="nombre"
                label="Nombre"
                required
            />

            {{-- Categoría --}}
                <x-input-select
                    name="categoria_id"
                    label="Categoría"
                    :options="$categorias->pluck('nombre', 'id')"
                    required
                />

            <!-- Botones -->
            <div class="flex justify-end space-x-2 mt-4">
                <x-button-link href="{{ route('admin.tipos_articulos.index') }}">Cancelar</x-button-link>
                <x-button type="submit" >Crear</x-button>             
            </div>
        </form>
    </div>

</x-layouts.app>

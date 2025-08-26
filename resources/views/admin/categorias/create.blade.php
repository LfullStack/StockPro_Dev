<x-layouts.app :title="'Crear Categoría | StockPro'">

    <flux:breadcrumbs class="mb-8 ">
        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('admin.categorias.index')">Categorías</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>Nuevo</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="max-w-xl mx-auto p-6 bg-white rounded shadow dark:bg-zinc-800">
        <form method="POST" action="{{ route('admin.categorias.store') }}">
            @csrf

            {{-- Nombre de la Categoría --}}
            <x-input-text
                name="nombre"
                label="Nombre"
                required
            />

            {{-- Tipo de Artículo --}}
            <x-input-text
                name="tipo_articulo"
                label="Tipo de Artículo"
                required
            />

            <!-- Botones -->
            <div class="flex justify-end space-x-2 mt-4">
                <x-button-link href="{{ route('admin.categorias.index') }}">Cancelar</x-button-link>
                <x-button type="submit" >Crear</x-button>             
            </div>
        </form>
    </div>

</x-layouts.app>

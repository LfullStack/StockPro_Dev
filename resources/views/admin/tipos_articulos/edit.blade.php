<x-layouts.app :title="'Editar Tipo de Artículo | StockPro'">

    <flux:breadcrumbs class="mb-8">
        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('admin.tipos_articulos.index')">Tipos de Artículo</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>Editar</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="max-w-xl mx-auto p-6 bg-white rounded shadow dark:bg-zinc-800">
        <form method="POST" action="{{ route('admin.tipos_articulos.update', $tipoArticulo) }}">
            @csrf
            @method('PUT')

            {{-- Nombre --}}
                <x-input-text
                    name="nombre"
                    label="Nombre"
                    :value="$tipoArticulo->nombre"
                    required
                />

            {{-- Categoría --}}
                <x-input-select
                    name="categoria_id"
                    label="Categoría"
                    :options="$categorias->pluck('nombre', 'id')"
                    :selected="$tipoArticulo->categoria_id"
                    required
                />

            <!-- Botones -->
                <div class="flex justify-end space-x-2 mt-8">
                    <x-button-link href="{{ route('admin.tipos_articulos.index') }}">Cancelar</x-button-link>
                    <x-button type="submit">Actualizar</x-button>             
                </div>
        </form>
    </div>

</x-layouts.app>

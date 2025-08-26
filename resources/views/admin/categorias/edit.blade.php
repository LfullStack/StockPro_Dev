<x-layouts.app :title="'Editar Categoría | StockPro'">

    <flux:breadcrumbs class="mb-8">
        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('admin.categorias.index')">Categorías</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>Editar</flux:breadcrumbs.item>
    </flux:breadcrumbs>

        <div class="max-w-xl mx-auto p-6 bg-white rounded shadow dark:bg-zinc-800">
            <form method="POST" action="{{ route('admin.categorias.update', $categoria) }}">
                @csrf
                @method('PUT')

                {{-- Nombre --}}
                    <x-input-text
                        name="nombre"
                        label="Nombre"
                        :value="$categoria->nombre"
                        required
                    />



                    <!-- Botones -->
                <div class="flex justify-end space-x-2">
                    <x-button-link href="{{ route('admin.categorias.index') }}">Cancelar</x-button-link>
                    <x-button type="submit" >Actualizar</x-button>             
                </div>
            </div>
        </form>
    </div>

</x-layouts.app>

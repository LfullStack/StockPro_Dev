<x-layouts.app :title="'Registrar Unidad medida | StockPro'">
    <flux:breadcrumbs class="mb-8">
        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('admin.unidades_medidas.index')">Unidad de Medida</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>Nuevo</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="max-w-xl mx-auto p-6 bg-white rounded shadow dark:bg-zinc-800">
        <form method="POST" action="{{ route('admin.unidades_medidas.store') }}">
            @csrf

            {{-- Nombre --}}
            <x-input-text
                name="nombre"
                label="Nombre"
                required
            />

            {{-- Prefijo --}}
            <x-input-text
                name="prefijo"
                label="Prefijo"
                required
            />


            <!-- Botones -->
            <div class="flex justify-end space-x-2 mt-4">
                <x-button-link href="{{ route('admin.unidades_medidas.index') }}">Cancelar</x-button-link>
                <x-button type="submit" >Crear</x-button>             
            </div>
        </form>
    </div>
</x-layouts.app>

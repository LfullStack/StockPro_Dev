<x-layouts.app :title="'Registrar Proveedores | StockPro'">
    <flux:breadcrumbs class="mb-8">
        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('admin.proveedores.index')">Proveedores</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>Nuevo</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="max-w-xl mx-auto p-6 bg-white rounded shadow dark:bg-zinc-800">
        <form method="POST" action="{{ route('admin.proveedores.store') }}">
            @csrf

            {{-- Nombre --}}
            <x-input-text
                name="nombre"
                label="Nombre"
                required
            />

            {{-- NIT --}}
            <x-input-text
                name="nit"
                label="NIT"
                required
            />

            {{-- Teléfono --}}
            <x-input-text
                name="telefono"
                label="Teléfono"
                required
            />

            {{-- Email --}}
            <x-input-text
                name="email"
                label="Email"
                type="email"
                required
            />

            {{-- Dirección --}}
            <x-input-text
                name="direccion"
                label="Dirección"
                required
            />

            {{-- Ubicación --}}
            <x-input-text
                name="ubicacion"
                label="Ubicación"
                placeholder="Ciudad, País"
                required
            />

            <!-- Botones -->
            <div class="flex justify-end space-x-2 mt-4">
                <x-button-link href="{{ route('admin.proveedores.index') }}" >Cancelar</x-button-link>
                <x-button type="submit">Crear</x-button>             
            </div>
        </form>
    </div>
    
    @include('components.scripts.datatable-delete')
</x-layouts.app>

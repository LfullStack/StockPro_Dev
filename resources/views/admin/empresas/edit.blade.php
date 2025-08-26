<x-layouts.app :title="'Registrar Empresas | StockPro'">
    <flux:breadcrumbs class="mb-8">
        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('admin.empresas.index')">Empresas</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>Editar</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="max-w-xl mx-auto p-6 bg-white rounded shadow dark:bg-zinc-800">
        <form method="POST" action="{{ route('admin.empresas.update',$empresa) }}">
            @csrf
            @method('PUT')

            {{-- Nombre --}}
            <x-input-text
                name="nombre"
                label="Nombre"
                :value="$empresa->nombre"
                required
            />

            {{-- NIT --}}
            <x-input-text
                name="nit"
                label="NIT"
                :value="$empresa->nit"
                required
            />

            {{-- Teléfono --}}
            <x-input-text
                name="telefono"
                label="Teléfono"
                :value="$empresa->telefono"
                required
            />

            {{-- Email --}}
            <x-input-text
                name="email"
                label="Email"
                type="email"
                :value="$empresa->email"
                required
            />

            {{-- Dirección --}}
            <x-input-text
                name="direccion"
                label="Dirección"
                :value="$empresa->direccion"
                required
            />

            {{-- Ubicación --}}
            <x-input-text
                name="ubicacion"
                label="Ubicación"
                placeholder="Ciudad, País"
                :value="$empresa->ubicacion"
                required
            />

            <!-- Botones -->
                <div class="flex justify-end space-x-2">
                    <x-button-link href="{{ route('admin.empresas.index') }}" >Cancelar</x-button-link>
                    <x-button type="submit" >Actualizar</x-button>             
                </div>
        </form>
    </div>
</x-layouts.app>

<x-layouts.app :title="'Registrar Usuario | StockPro'">
    <flux:breadcrumbs class="mb-8">
        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('admin.registro_usuario.index')">Usuarios</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>Nuevo</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="max-w-xl mx-auto p-6 bg-white rounded shadow dark:bg-zinc-800">
       <form method="POST" action="{{ route('admin.registro_usuario.store') }}">
    @csrf



    {{-- Nombre --}}
    <x-input-text
        name="name"
        label="Nombre"
        placeholder="Nombre completo"
        required
    />

    {{-- Email --}}
    <x-input-text
        name="email"
        label="Email"
        type="email"
        placeholder="tuemail@example.com"
        required
    />

    {{-- Teléfono --}}
    <x-input-text
        name="telefono"
        label="Teléfono"
        placeholder="Número de teléfono"
    />

    {{-- Contraseña --}}
    <x-input-text
        name="password"
        label="Contraseña"
        type="password"
        required
    />

    {{-- Confirmar Contraseña --}}
    <x-input-text
        name="password_confirmation"
        label="Confirmar Contraseña"
        type="password"
        required
    />

    <!-- Botones -->
    <div class="flex justify-end space-x-2 mt-4">
        <x-button-link href="{{ route('admin.registro_usuario.index') }}">Cancelar</x-button-link>
        <x-button type="submit">Crear</x-button>             
    </div>
</form>

    </div>
    
    @include('components.scripts.datatable-delete')
</x-layouts.app>

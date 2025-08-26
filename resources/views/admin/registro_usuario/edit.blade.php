<x-layouts.app :title="'Editar Usuarios | StockPro'">
    <flux:breadcrumbs class="mb-8">
        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('admin.registro_usuario.index')">Usuarios</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>Editar</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="max-w-xl mx-auto p-6 bg-white rounded shadow dark:bg-zinc-800">
        <form action="{{ route('admin.registro_usuario.update', $usuario->id) }}" method="POST">
            @csrf
            @method('PUT')


            {{-- ID --}}
            <x-input-text
                name="id"
                label="ID"
                :value="$usuario->id"
                readonly
            />

            {{-- Nombre --}}
            <x-input-text
                name="name"
                label="Nombre"
                :value="$usuario->name"
                required
            />

            {{-- Teléfono --}}
            <x-input-text
                name="telefono"
                label="Teléfono"
                :value="$usuario->telefono"
                required
            />

            {{-- Email --}}
            <x-input-text
                name="email"
                label="Email"
                type="email"
                :value="$usuario->email"
                required
            />

            <!-- Botones -->
            <div class="flex justify-end space-x-2">
                <x-button-link href="{{ route('admin.registro_usuario.index') }}">Cancelar</x-button-link>
                <x-button type="submit">Actualizar</x-button>             
            </div>
        </form>
    </div>
</x-layouts.app>

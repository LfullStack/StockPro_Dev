<x-layouts.app :title="'Asiganr Roles | StockPro'">

    <flux:breadcrumbs class="mb-8">
        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('admin.users.index')">Rol Usuario</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>Editar</flux:breadcrumbs.item>
    </flux:breadcrumbs>

        <div class="max-w-xl mx-auto p-6 bg-white rounded shadow dark:bg-zinc-800">
    <form method="POST" action="{{ route('admin.users.update', $user) }}">
        @csrf
        @method('PUT')

        {{-- Nombre --}}
        <x-input-text
            name="nombre"
            label="Nombre"
            :value="old('nombre', $user->name)"
            readonly
            required
        />

        {{-- Roles --}}
        
        <div class="mt-4">
            <h5>Listado de Roles</h5>
            <x-label value="Roles" class="mb-2" />
            
            <div class="space-y-2">
                @foreach ($roles as $role)
                    <label class="flex items-center space-x-2 text-sm">
                        <input
                            type="radio"
                            name="roles[]"
                            value="{{ $role->id }}"
                            {{ in_array($role->id, old('roles', $user->roles->pluck('id')->toArray())) ? 'checked' : '' }}
                            class="form-radio h-5 w-5 text-blue-600 border-gray-300 rounded focus:ring focus:ring-blue-200"
                        />
                        <span class="text-zinc-700 dark:text-zinc-200">{{ $role->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        {{-- Botones --}}
        <div class="flex justify-end space-x-2 mt-6">
            <x-button-link href="{{ route('admin.users.index') }}" color="red">Cancelar</x-button-link>
            <x-button type="submit" color="blue">Asignar Rol</x-button>             
        </div>
    </form>
</div>


</x-layouts.app>

<x-layouts.app :title="'Registro de Usuarios | StockPro'"> 
    <div class="mb-8 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Usuarios</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        {{-- Botón para crear nuevo usuario --}}
        <x-button-crear href="{{ route('admin.registro_usuario.create') }}" color="red">
            Nuevo
        </x-button-crear>
    </div>

    <div class="card mt-8 overflow-x-auto w-full">
        <table id="tabla-usuarios" class="display table datatable min-w-full table-auto">
            <thead>
               <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th> 
                    <th>Teléfono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($usuarios as $usuario)
                    <tr>
                        <td>{{ $usuario->id }}</td>
                        <td>{{ $usuario->name }}</td>
                        <td>{{ $usuario->email }}</td>
                        <td>{{ $usuario->telefono }}</td>
                        <td>
                            <div class="flex justify-end gap-2">
                                {{-- Botón editar --}}
                                <x-button-link href="{{ route('admin.registro_usuario.edit', $usuario->id) }}">
                                    Editar
                                </x-button-link>

                                {{-- Botón eliminar --}}
                                <form class="confirmar-eliminar" action="{{ route('admin.registro_usuario.destroy', $usuario->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <x-button type="submit">
                                        Eliminar
                                    </x-button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @include('components.scripts.datatable-delete')
</x-layouts.app>

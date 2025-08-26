<x-layouts.app :title="'Ver Roles | StockPro'"> 

    <div class="mb-8 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{route('dashboard')}}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item >Roles de Usuarios</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <div class="card mt-8 overflow-x-auto w-full">
        <table id="tabla-users" class="display table datatable min-w-full table-auto">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Acciones</th>


                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->roles->first()?->name ?? 'Sin rol' }}</td>
                        <td class="flex justify-end">
                            <x-button-link  href="{{ route('admin.users.edit', $user) }}" color="red">
                                    Editar
                                </x-button-link>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @include('components.scripts.datatable-delete')

</x-layouts.app>
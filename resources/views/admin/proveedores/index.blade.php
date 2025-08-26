<x-layouts.app :title="'Ver Proveedores | StockPro'"> 
    <div class="mb-8 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{route('dashboard')}}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item >Proveedores</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <x-button-crear href="{{ route('admin.proveedores.create') }}" color="red">Nuevo</x-button-link>
    </div>
    <div class="card mt-8 overflow-x-auto w-full">
        <table id="tabla-proveedores" class="display table datatable min-w-full table-auto">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Nit</th>
                    <th>Nombre</th>
                    <th>Telefono</th>
                    <th>Email</th>
                    <th>Direccion</th>
                    <th>Ubicacion</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($proveedores as $proveedor)
                    <tr>
                        <td>{{ $proveedor->id }}</td>
                        <td>{{ $proveedor->nit }}</td>
                        <td>{{ $proveedor->nombre }}</td>
                        <td>{{ $proveedor->telefono }}</td>
                        <td>{{ $proveedor->email }}</td>
                        <td>{{ $proveedor->direccion }}</td>
                        <td>{{ $proveedor->ubicacion }}</td>
                        <td width="">
                            <div class="flex justify-end gap-2">
                                <x-button-link href="{{ route('admin.proveedores.edit',$proveedor) }}"  >Editar</x-button-link>
                                <form class="confirmar-eliminar" action="{{ route('admin.proveedores.destroy',$proveedor->id)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <x-button type="submit" >
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
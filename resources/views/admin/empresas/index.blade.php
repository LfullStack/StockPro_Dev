<x-layouts.app :title="'Ver Empresa | StockPro'"> 

    <div class="mb-8 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{route('dashboard')}}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item >Empresa</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <x-button-crear href="{{ route('admin.empresas.create') }}" >Nuevo</x-button-crear>
    </div>

    <div class="card mt-8 overflow-x-auto w-full">
        
        
        <table id="tabla-empresas" class="display table datatable min-w-full table-auto">
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
                @foreach ($empresas as $empresa)
                    <tr>
                        <td>{{ $empresa->id }}</td>
                        <td>{{ $empresa->nit }}</td>
                        <td>{{ $empresa->nombre }}</td>
                        <td>{{ $empresa->telefono }}</td>
                        <td>{{ $empresa->email }}</td>
                        <td>{{ $empresa->direccion }}</td>
                        <td>{{ $empresa->ubicacion }}</td>
                        <td width="">
                            <div class="flex justify-end gap-2">
                                <x-button-link href="{{ route('admin.empresas.edit',$empresa) }}">Editar</x-button-link>
                                <form class="confirmar-eliminar" action="{{ route('admin.empresas.destroy',$empresa->id)}}" method="POST">
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
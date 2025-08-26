<x-layouts.app :title="'Ver unidades de medida | StockPro'"> 

    <div class="mb-8 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{route('dashboard')}}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item >Unidades de Medida</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <x-button-crear href="{{ route('admin.unidades_medidas.create') }}" >Nuevo</x-button-crear>
    </div>

    <div class="card mt-8 overflow-x-auto w-full">
        <table id="tabla-unidades_medidas" class="display table datatable min-w-full table-auto">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Prefijo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($unidadMedidas as $unidadMedida)
                    <tr>
                        <td>{{ $unidadMedida->id }}</td>
                        <td>{{ $unidadMedida->nombre }}</td>
                        <td>{{ $unidadMedida->prefijo }}</td>

                        <td width="">
                            <div class="flex justify-end gap-2">
                                <x-button-link href="{{ route('admin.unidades_medidas.edit', $unidadMedida) }}">Editar</x-button-link>
                                
                                    
                                <form class="confirmar-eliminar" action="{{ route('admin.unidades_medidas.destroy',$unidadMedida->id)}}" method="POST">
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
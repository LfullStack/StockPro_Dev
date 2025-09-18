<x-layouts.app :title="'Categorías | StockPro'"> 

    <div class="mb-8 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{route('dashboard')}}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item >Categorias</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <x-button-crear href="{{ route('admin.categorias.create') }}" >Nuevo</x-button-crear>
    </div>

    <div class="card mt-8 overflow-x-auto w-full">
        <table id="tabla-categorias" class="display table datatable min-w-full table-auto">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categorias as $categoria)
                    <tr>
                        <td>{{ $categoria->id }}</td>
                        <td>{{ $categoria->nombre }}</td>
                        <td width="">
                            <div class="flex justify-end gap-2">
                                <x-button-link href="{{ route('admin.categorias.edit', $categoria) }}" >
                                    Editar
                                </x-button-link>

                                <form class="confirmar-eliminar" action="{{ route('admin.categorias.destroy', $categoria->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <x-button type="submit" color="red">
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
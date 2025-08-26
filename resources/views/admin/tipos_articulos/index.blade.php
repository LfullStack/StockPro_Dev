<x-layouts.app :title="'Ver Tipos de Artículo | StockPro'">

    <div class="mb-8 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Tipos de Artículo</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <x-button-crear href="{{ route('admin.tipos_articulos.create') }}" >Nuevo</x-button-crear>
    </div>

    <div class="card mt-8 overflow-x-auto w-full ">
        <table id="tabla-tipo-articulos " class="display table datatable min-w-full table-auto">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tipo de Artículo</th>
                    <th>Categoría</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tipoArticulos as $tipo)
                    <tr>
                        <td>{{ $tipo->id }}</td>
                        <td>{{ $tipo->nombre }}</td>
                        <td>{{ $tipo->categoria->nombre ?? 'Sin categoría' }}</td>
                        <td>
                            <div class="flex justify-end gap-2">
                                <x-button-link href="{{ route('admin.tipos_articulos.edit', $tipo) }}" >
                                    Editar
                                </x-button-link>
                                <form class="confirmar-eliminar" action="{{ route('admin.tipos_articulos.destroy', $tipo->id) }}" method="POST">
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


<x-layouts.app :title="'Ver Inventario || StockPro'"> 

    <div class="mb-8 flex justify-between items-center">
        <flux:breadcrumbs>

            <flux:breadcrumbs.item href="{{route('dashboard')}}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item >Inventario</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <div class="card mt-8 overflow-x-auto w-full">
        <table id="tabla-inventarios" class="display table datatable min-w-full table-auto">
            <thead>
                <tr>
                    <th>ID Producto</th>
                    <th>Nombre</th>
                    <th>Unidad Medida</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Descuento</th>
                    <th>Tienda</th>
                    <th>Fecha de ingréso</th>
                    <th>Fecha modificacíon</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($inventarios as $inventario)
                    <tr>
                        <td>{{ $inventario->producto->id }}</td>
                        <td>{{ $inventario->producto->nombre }}</td>
                        <td>{{ $inventario->unidad_medida }}</td>
                        <td>{{ $inventario->cantidad }}</td>
                        <td>${{ number_format($inventario->producto->precio, 2) }}</td>
                        <td>{{ $inventario->producto->descuento }}</td>
                        <td>{{ $inventario->empresa->nombre }}</td>
                        <td>{{ $inventario->created_at }}</td>
                        <td>{{ $inventario->updated_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @include('components.scripts.datatable-delete')

</x-layouts.app>
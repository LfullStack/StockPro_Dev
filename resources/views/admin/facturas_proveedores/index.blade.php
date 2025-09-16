<x-layouts.app :title="'Facturas Proveedores | StockPro'"> 

    <div class="mb-8 flex justify-between items-center">
        <flux:breadcrumbs>

            <flux:breadcrumbs.item href="{{route('dashboard')}}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item >Facturas Proveedores</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <x-button-crear href="{{ route('admin.facturas_proveedores.create') }}" >Nuevo</x-button-crear>
    </div>
    
    <div class="card mt-8 overflow-x-auto w-full min-w-full table-auto">
        <table id="tabla-facturas_proveedores" class="display table datatable">
            <thead>
                <tr>
                    <th>id</th>
                    <th>ID Factura</th>
                    <th>Proveedor</th>
                    <th>Tienda</th>
                    <th>Fecha Pago</th>
                    <th>Total</th>
                    <th>Factura PDF</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($facturas as $factura)
                    <tr>
                        <td>{{ $factura->id }}</td>
                        <td>{{ $factura->numero_factura }}</td>
                        <td>{{ $factura->proveedor->nombre ?? 'N/A' }}</td>
                        <td>{{ $factura->empresa->nombre ?? 'N/A' }}</td>
                        <td>{{ $factura->fecha_pago }}</td>
                        <td>${{ number_format($factura->total, 2, ',', '.') }}</td>
                        <td>
                            @if($factura->pdf_path)
                                <a href="{{ asset($factura->pdf_path) }}" target="_blank" class="inline-block px-2 py-1 bg-gray-600 text-white text-xs rounded hover:bg-gray-700">
                                    Ver PDF
                                </a>
                            @else
                                <span class="text-gray-500 text-xs">Sin archivo</span>
                            @endif
                        </td>



                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @include('components.scripts.datatable-delete')

</x-layouts.app>
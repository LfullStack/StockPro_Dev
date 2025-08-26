<x-layouts.app :title="'Reporte de Facturas de Clientes'">
    <div class="mb-8 flex justify-between items-center">
        <flux:breadcrumbs>

            <flux:breadcrumbs.item href="{{route('dashboard')}}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item >Reportes Ventas</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>
    <div class="max-w-4xl mx-auto bg-white dark:bg-neutral-800 rounded p-6 shadow">

        <form action="{{ route('admin.reportes.facturas_clientes.index') }}" method="GET" class="space-y-4">
            {{-- Empresa --}}
            <div>
                <label for="empresa_id" class="mb-2 block font-semibold">Empresa:</label>
                <select name="empresa_id" id="empresa_id" class="form-input">
                    <option value="">Todas</option>
                    @foreach($empresas as $id => $nombre)
                        <option value="{{ $id }}" {{ request('empresa_id') == $id ? 'selected' : '' }}>
                            {{ $nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Fechas --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="fecha_inicio" class="mb-2 block font-semibold">Fecha Inicio:</label>
                    <input type="date" name="fecha_inicio" id="fecha_inicio" value="{{ request('fecha_inicio') }}" class="form-input">
                </div>

                <div>
                    <label for="fecha_fin" class="mb-2 block font-semibold">Fecha Fin:</label>
                    <input type="date" name="fecha_fin" id="fecha_fin" value="{{ request('fecha_fin') }}" class="form-input">
                </div>
            </div>

            {{-- Botones --}}
            <div class="flex justify-between mt-4">
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                    Buscar
                </button>

                @if(request('fecha_inicio') && request('fecha_fin'))
                    <a href="{{ route('admin.reportes.facturas_clientes.exportar', request()->all()) }}"
                        target="_blank"
                        class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                        Descargar Excel
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Resultados --}}
    @if(isset($facturas) && $facturas->count())
        <div class="mt-8">
            <h2 class="text-lg font-semibold mb-2">Resultados</h2>
            <table id="tabla-reportes_facturas_clientes" class="display table datatable ">
                <thead >
                    <tr >
                        <th>Fecha</th>
                        <th>Empresa</th>
                        <th>Cliente</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($facturas as $factura)
                        <tr>
                            <td>{{ $factura->created_at->format('Y-m-d') }}</td>
                            <td>{{ $factura->cliente->name ?? '-' }}</td>
                            <td>${{ number_format($factura->total, 0, ',', '.') }}</td>
                            <td>{{ $factura->empresa->nombre ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @elseif(request()->all())
        <div class="mt-6 text-red-600 dark:text-red-300">
            No se encontraron facturas con los criterios seleccionados.
        </div>
    @endif
    @include('components.scripts.datatable-delete')
</x-layouts.app>

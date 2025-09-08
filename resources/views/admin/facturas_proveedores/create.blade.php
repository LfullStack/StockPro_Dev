<x-layouts.app :title="'Registrar Factura Proveedor |StockPro'">
    <flux:breadcrumbs class="mb-6">
        <flux:breadcrumbs.item :href="route('dashboard')">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('admin.facturas_proveedores.index')">Facturas Proveedor</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>Registrar</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <form method="POST" action="{{ route('admin.facturas_proveedores.store') }}" id="form-factura">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <x-form.input name="numero_factura" label="Número de Factura" required />
            <x-form.input name="fecha_pago" label="Fecha de Pago" type="date" required />
            <x-form.select name="proveedor_id" label="Proveedor" :options="$proveedores->pluck('nombre', 'id')" required />
            <x-form.select name="empresa_id" label="Empresa" :options="$empresas->pluck('nombre', 'id')" required />
        </div>

        <hr class="my-6">

        <h4 class="text-lg font-semibold mb-3">Ítems</h4>

        <div class="overflow-x-auto">
            <table id="items-table" class="min-w-full divide-y divide-black-500 border border-black-500">
                <thead class="bg-black-700 text-white-700 text-sm">
                    <tr>
                        <th class="px-4 py-2 text-left">Producto</th>
                        <th class="px-4 py-2 text-left">Unidad</th>
                        <th class="px-4 py-2 text-left">Cantidad</th>
                        <th class="px-4 py-2 text-left">Precio Sin IVA</th>
                        <th class="px-4 py-2 text-left">Descuento (%)</th>
                        <th class="px-4 py-2 text-left">Subtotal</th>
                        <th class="px-4 py-2 text-center">Acción</th>
                    </tr>
                </thead>
                <tbody class="text-sm bg-gray divide-y divide-gray-200"></tbody>
            </table>
        </div>

        <button type="button" id="add-item" class="mt-4 px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
            + Agregar Ítem
        </button>
        
        <input type="hidden" name="items_json" id="items-json">

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 justify-end mt-6">
            <div class="form-input">
                <label class="block text-sm font-medium text-white-700 mb-1">Subtotal</label>
                <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" id="subtotal-general" readonly>
            </div>
            <div class="form-input">
                <label class="block text-sm font-medium text-white-700 mb-1">Descuentos</label>
                <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" id="descuento-general" readonly>
            </div>
            <div class="form-input">
                <label class="block text-sm font-medium text-white-700 mb-1">IVA (19%)</label>
                <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" id="impuesto-general" readonly>
            </div>
            <div class="form-input">
                <label class="block text-sm font-medium text-white-700 mb-1">Total Neto</label>
                <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" id="total-general" readonly>
            </div>
        </div>

        <div class="mt-8 flex gap-4 ">
            <x-button-link href="{{ route('admin.facturas_proveedores.index') }}" >
                    Cancelar
                </x-button-link>
            <x-button type="submit" >Guardar Factura</x-button>
            <div class="flex justify-end gap-2">
                
        </div>
    </form>

    @include('components.scripts.factura-crear')
</x-layouts.app>
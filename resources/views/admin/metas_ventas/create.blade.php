<x-layouts.app :title="'Nueva Meta de Venta || StockPro'">

    <flux:breadcrumbs class="mb-8">
        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('admin.empresas.index')">Metas Ventas</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>Crear</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <h1 class="text-2xl font-bold mb-4">Nueva Meta de Venta</h1>
    <form action="{{ route('admin.metas_ventas.store') }}" method="POST">
        @include('admin.metas_ventas._form')
    </form>
</x-layouts.app>

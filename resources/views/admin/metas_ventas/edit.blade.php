<x-layouts.app :title="'Editar Meta de Venta || StockPro'">

    <flux:breadcrumbs class="mb-8">
        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('admin.metas_ventas.index')">Metas Ventas</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>Editar</flux:breadcrumbs.item>
    </flux:breadcrumbs>


    <form action="{{ route('admin.metas_ventas.update', $meta) }}" method="POST">
        @method('PUT')
        @include('admin.metas_ventas._form')
    </form>
</x-layouts.app>

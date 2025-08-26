<x-layouts.app :title="'Metas de Venta'">

    <div class="mb-8 flex justify-between items-center">
        <flux:breadcrumbs>

            <flux:breadcrumbs.item href="{{route('dashboard')}}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item >Metas Ventas</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <x-button-crear href="{{ route('admin.metas_ventas.create') }}" >Nuevo</x-button-crear>
    </div>



    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="min-w-full bg-white dark:bg-neutral-900 rounded shadow">
        <thead>
            <tr class="bg-gray-100 dark:bg-neutral-800 text-left">
                <th class="px-4 py-2">Tipo</th>
                <th class="px-4 py-2">Monto</th>
                <th class="px-4 py-2">Año</th>
                <th class="px-4 py-2">Mes</th>
                <th class="px-4 py-2">Semana</th>
                <th class="px-4 py-2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($metas as $meta)
                <tr class="border-t dark:border-neutral-700">
                    <td class="px-4 py-2">{{ ucfirst($meta->tipo) }}</td>
                    <td class="px-4 py-2">${{ number_format($meta->monto_meta, 0) }}</td>
                    <td class="px-4 py-2">{{ $meta->anio }}</td>
                    <td class="px-4 py-2">{{ $meta->mes ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $meta->semana ?? '-' }}</td>
                    <td class="px-4 py-2 flex gap-2">
                        <x-button-link href="{{ route('admin.metas_ventas.edit',$meta) }}">Editar</x-button-link>
                        <form action="{{ route('admin.metas_ventas.destroy', $meta) }}" method="POST" onsubmit="return confirm('¿Eliminar esta meta?')">
                            @csrf @method('DELETE')
                            <x-button type="submit" >Eliminar</x-button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $metas->links() }}
    </div>

</x-layouts.app>

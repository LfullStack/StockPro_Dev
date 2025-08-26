<x-layouts.app :title="'Ver Productos | StockPro'"> 
    <div class="mb-8 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Productos</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <x-button-crear href="{{ route('admin.productos.create') }}" >Nuevo</x-button-crear>
    </div>

    <div class="card mt-8 overflow-x-auto w-full">
        <table id="tabla-productos" class="display table datatable min-w-full table-auto">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Unidad Medida</th>
                    <th>Precio</th>
                    <th>Descuento</th>
                    <th>Proveedor</th>
                    <th>Categoria</th>
                    <th>Tipo Articulo</th>
                    <th>Foto</th>
                    <th>Descripcíon</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($productos as $producto)
                <tr>
                    <td>{{ $producto->id }}</td>
                    <td>{{ $producto->nombre }}</td>
                    <td>{{ $producto->unidadMedida->prefijo ?? 'Sin unidad' }}</td>
                    <td>${{ number_format($producto->precio, 2)}}</td>
                    <td>{{ $producto->descuento }}%</td>
                    <td>{{ $producto->proveedor->nombre }}</td>
                    <td>{{ $producto->categoria->nombre }}</td>
                    <td>{{ $producto->tipoArticulo->nombre }}</td>

                    {{-- Imagen miniatura con soporte para URLs externas --}}
                    <td>
                        @if ($producto->foto)
                            @php
                                $foto = Str::startsWith($producto->foto, ['http://', 'https://'])
                                    ? $producto->foto
                                    : asset('storage/' . $producto->foto);
                            @endphp
                            <img src="{{ $foto }}"
                                alt="Foto"
                                class="w-16 h-16 object-cover rounded cursor-pointer"
                                onclick="mostrarModalImagen('{{ $foto }}')">
                        @else
                            <span class="text-gray-500 italic">Sin imagen</span>
                        @endif
                    </td>

                    {{-- Descripción truncada --}}
                    <td>
                        <span title="{{ $producto->descripcion }}">
                            {{ \Illuminate\Support\Str::limit($producto->descripcion, 30) }}
                        </span>
                    </td>

                    <td>
                        <div class="flex justify-end gap-2">
                            <x-button-link href="{{ route('admin.productos.edit', $producto) }}" color="gray">
                                    Editar
                                </x-button-link>

                                <form class="confirmar-eliminar" action="{{ route('admin.productos.destroy', $producto->id) }}" method="POST">
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

        <!-- Modal Imagen -->
        <div id="modal-imagen" class="fixed inset-0 bg-black bg-opacity-60 hidden items-center justify-center z-50">
            <div class="bg-white rounded shadow p-4 max-w-2xl w-full">
                <img id="imagen-modal-src" src="" class="w-full max-h-[80vh] object-contain rounded">
                <div class="text-right mt-4">
                    <button onclick="cerrarModalImagen()" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 text-sm">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    @include('components.scripts.datatable-delete')
    @push('scripts')
    <script>


        // Modal imagen
        function mostrarModalImagen(url) {
            const modal = document.getElementById('modal-imagen');
            const img = document.getElementById('imagen-modal-src');
            img.src = url;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function cerrarModalImagen() {
            const modal = document.getElementById('modal-imagen');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.getElementById('imagen-modal-src').src = '';
        }
    </script>
    @endpush

</x-layouts.app>

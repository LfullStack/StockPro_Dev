@php
    $groups = [
        'Plataforma' => [

            [
                'name' => 'Dashboard',
                'icon' => 'home',
                'url' => route('dashboard'),
                'current' => request()->routeIs('dashboard'),
            ],
            
            [
                'name' => 'Posts',
                'icon' => 'pencil-square',
                'url' => route('admin.posts.index'),
                'current' => request()->routeIs('admin.posts.*'),
            ],

            [
                'name' => 'Eventos' . (($sinVer ?? 0) > 0 ? ' <span class="ml-1 inline-block rounded-full bg-red-600 px-2 py-0.5 text-xs font-semibold text-white align-middle">' . $sinVer . '</span>' : ''),
                'icon' => 'bell-alert',
                'url' => route('admin.eventos.index'),
                'current' => request()->routeIs('admin.eventos.*'),
            ],


            [
                'name' => 'Metas Ventas',
                'icon' => 'rocket-launch',
                'url' => route('admin.metas_ventas.index'),
                'current' => request()->routeIs('admin.metas_ventas.*'),
            ],

        ],

        'Productos' => [

            [
                'name' => 'Categorias',
                'icon' => 'funnel',
                'url' => route('admin.categorias.index'),
                'current' => request()->routeIs('admin.categorias.*'),
            ],

            [
                'name' => 'Tipos de Articulos',
                'icon' => 'tag',
                'url' => route('admin.tipos_articulos.index'),
                'current' => request()->routeIs('admin.tipos_articulos.*'),
            ],

            [
                'name' => 'Unidades de Medidas',
                'icon' => 'beaker',
                'url' => route('admin.unidades_medidas.index'),
                'current' => request()->routeIs('admin.unidades_medidas.*'),
            ],

            [
                'name' => 'Items',
                'icon' => 'clipboard-document-list',
                'url' => route('admin.productos.index'),
                'current' => request()->routeIs('admin.productos.*'),
            ],

        ],

        'Facturacíon' => [

            [
                'name' => 'Facturas Proveedores',
                'icon' => 'clipboard-document',
                'url' => route('admin.facturas_proveedores.index'),
                'current' => request()->routeIs('admin.facturas_proveedores.*'),
            ],

            [
                'name' => 'Facturas Clientes',
                'icon' => 'clipboard-document-list',
                'url' => route('admin.facturas_clientes.index'),
                'current' => request()->routeIs('admin.facturas_clientes.*'),
            ]
        ],

        'Mi Negocio' => [

            [
                'name' => 'Empresas',
                'icon' => 'building-storefront',
                'url' => route('admin.empresas.index'),
                'current' => request()->routeIs('admin.empresas.*'),
            ],

            
            [
                'name' => 'Inventario',
                'icon' => 'table-cells',
                'url' => route('admin.inventarios.index'),
                'current' => request()->routeIs('admin.inventarios.*'),
            ],

            [
                'name' => 'Proveedores',
                'icon' => 'user-group',
                'url' => route('admin.proveedores.index'),
                'current' => request()->routeIs('admin.proveedores.*'),
            ],

            [
                'name' => 'Registro de Usuarios',
                'icon' => 'user-group',
                'url' => route('admin.registro_usuario.index'),
                'current' => request()->routeIs('admin.registro_usuario.*'),
            ],

            
            [   
                'name' => 'Roles Usuarios',
                'icon' => 'users',
                'url' => route('admin.users.index'),
                'current' => request()->routeIs('admin.users.*'),
            ]

            

        ],

        'Reportes de Facturacíon' => [

            [
                'name' => 'Reportes Ventas',
                'icon' => 'currency-dollar',
                'url' => route('admin.reportes.facturas_clientes.index'),
                'current' => request()->routeIs('admin.reportes.facturas_clientes.*'),
            ],
            
            [
                'name' => 'Reportes Compras',
                'icon' => 'currency-pound',
                'url' => route('admin.reportes.facturas_proveedores.index'),
                'current' => request()->routeIs('admin.reportes.facturas_proveedores.*'),
            ]
        ]
    ]
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
        
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <div class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <img src="{{ asset('img/logo.png') }}" alt="Logo" class="h-10 w-auto" />
                <h1 class="mb-0.5 truncate leading-tight font-semibold">StockPro</h1>

            </div>
            
            <flux:navlist variant="outline">
                @foreach ($groups as $group => $items)
                    <flux:navlist.group :heading="$group" class="grid">
                        @foreach ($items as $item)
                            <flux:navlist.item icon="{{ $item['icon'] }}" :href="$item['url']" :current="$item['current']" wire:navigate>
                                {!! $item['name'] !!}

                            </flux:navlist.item>
                        @endforeach
                    </flux:navlist.group>
                @endforeach
            </flux:navlist>


            <flux:spacer />

            <!-- Desktop User Menu -->
            <flux:dropdown class="hidden lg:block" position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon:trailing="chevrons-up-down"
                />

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}
        <!-- jQuery y DataTables JS -->
        <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        

        

        @if (session('swal'))

            <script>
                swal.fire(@json(session('swal')));
            </script>
            
        @endif
                @stack('scripts')
        @fluxScripts
    </body>
</html>

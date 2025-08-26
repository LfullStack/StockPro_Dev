<div class="relative">
    <div class="relative">
        <a href="{{ route('admin.eventos.index') }}" class="flex items-center text-gray-700 dark:text-gray-300 hover:text-indigo-500 gap-2">
            {{-- Icono de campana --}}
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>

            {{-- Texto y badge --}}
            <span class="relative">
                <span>Eventos</span>

                @if($sinVer > 0)
                    <span class="absolute -top-2 -right-4 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-600 rounded-full">
                        {{ $sinVer }}
                    </span>
                @endif
            </span>
        </a>
    </div>

</div>

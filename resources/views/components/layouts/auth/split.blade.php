<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')
    <script>
    window.addEventListener('redirect-browser', event => {
        window.location.href = event.detail.url;
    });
</script>

</head>
<body class="min-h-screen bg-white antialiased dark:bg-gradient-to-b dark:from-neutral-950 dark:to-neutral-900">
    <div class="relative grid h-screen flex-col items-center justify-center px-8 sm:px-0 lg:max-w-none lg:grid-cols-2 lg:px-0">

        {{-- Panel izquierdo (fondo oscuro con logo + cita + ilustración) --}}
        <div class="relative hidden h-full flex-col p-10 text-white lg:flex dark:border-e dark:border-neutral-800 bg-neutral-900">
            {{-- Imagen administrativa --}}
            <img src="{{ asset('img/admin-illustration.svg') }}"
                    alt="Ilustración administrativa"
                    class="pointer-events-none absolute bottom-50 end-8 max-h-[60%] opacity-90 select-none" />

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="relative z-20 flex items-center text-lg font-medium" wire:navigate>
                <span class="flex h-10 w-10 items-center justify-center rounded-md">
                    <img src="{{ asset('img/logo.png') }}" alt="Logo" class="h-10 w-auto" />

                </span>
                StockPro
            </a>

            {{-- Frase motivacional --}}
        @php
            [$message, $author] = str(collect(config('frases'))->random())->explode('-');
        @endphp



            <div class="relative z-20 mt-auto">
                <blockquote class="space-y-2">
                    <flux:heading size="lg">&ldquo;{{ trim($message) }}&rdquo;</flux:heading>
                    <footer><flux:heading>{{ trim($author) }}</flux:heading></footer>
                </blockquote>
            </div>
        </div>

        {{-- Panel derecho (formulario) --}}
        <div class="w-full lg:p-8">
            <div class="mx-auto flex w-full flex-col justify-center space-y-6 sm:w-[350px]">
                {{-- Logo solo en pantallas pequeñas --}}
                <a href="{{ route('home') }}" class="z-20 flex flex-col items-center gap-2 font-medium lg:hidden" wire:navigate>
                    <span class="flex h-9 w-9 items-center justify-center rounded-md">
                        <x-app-logo-icon class="size-9 fill-current text-black dark:text-white" />
                    </span>
                    <span class="sr-only">{{ config('app.name', 'Laravel') }}</span>
                </a>

                {{-- Contenido dinámico del formulario (login, register, etc.) --}}
                {{ $slot }}
            </div>
        </div>
    </div>

    @fluxScripts
</body>
</html>

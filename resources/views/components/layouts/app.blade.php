<x-layouts.app.sidebar :title="$title ?? null">
    <flux:main>

        {{ $slot }}
        <x-flux-alert>
        </x-flux-alert>
    </flux:main>
    
</x-layouts.app.sidebar>

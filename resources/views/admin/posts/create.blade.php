<x-layouts.app :title="'Nuevo Post | StockPro'">
    <flux:breadcrumbs class="mb-8">
        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('admin.posts.index') }}">Posts</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>Nuevo</flux:breadcrumbs.item>
    </flux:breadcrumbs>
    <div class="max-w-xl mx-auto p-6 bg-white rounded shadow dark:bg-zinc-800">
        <form action="{{ route('admin.posts.store') }}" method="POST" class="space-y-4">
            @csrf

            <x-input label="Título" name="titulo" />
            <x-input label="Asunto" name="asunto"  />
            <x-textarea label="Contenido" name="contenido" required minlength="3" maxlength="200" />

            <div class="flex justify-end space-x-2 mt-4">
                <x-button-link href="{{ route('admin.posts.index') }}" >Cancelar</x-button-link>        
                <x-button type="submit" >Publicar Post</x-button> 
            </div>
        </form>
    </div>
</x-layouts.app>

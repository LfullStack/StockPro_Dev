@props([
    'name',
    'label',
    'type' => 'text',
    'value' => '',
    'required' => false,
])

<div>
    <label for="{{ $name }}" class="form-label mb-2">{{ $label }}</label>

    @if ($type === 'file')
        <input
            type="file"
            name="{{ $name }}"
            id="{{ $name }}"
            {{ $required ? 'required' : '' }}
            {{ $attributes->merge(['class' => 'form-input mb-4']) }}
        >

        {{-- Mostrar imagen actual si existe --}}
        @if ($value)
            <div class="mt-2">
                <img src="{{ asset('storage/' . $value) }}" alt="Vista previa" class="h-20 w-20 rounded-full object-cover border shadow">
            </div>
        @endif
    @else
        <input
            type="{{ $type }}"
            name="{{ $name }}"
            id="{{ $name }}"
            value="{{ old($name, $value) }}"
            {{ $required ? 'required' : '' }}
            {{ $attributes->merge(['class' => 'form-input mb-4']) }}
        >
    @endif

    @error($name)
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

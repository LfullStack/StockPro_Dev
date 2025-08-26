<!-- resources/views/components/form/input.blade.php -->
@props(['type' => 'text', 'name', 'label' => '', 'value' => '', 'required' => false])

<div class="mb-3">
    @if ($label)
        <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    @endif
    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        value="{{ old($name, $value) }}"
        {{ $attributes->merge(['class' => 'form-input' . ($errors->has($name) ? ' is-invalid' : '')]) }}
        {{ $required ? 'required' : '' }}
    >
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

@props([
    'name',
    'label',
    'options' => [],
    'selected' => '',
    'required' => false,
])  



<div>
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    <select
        name="{{ $name }}"
        id="{{ $name }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' => 'form-input']) }}
    >
        @foreach($options as $optionValue => $optionLabel)
            <option value="{{ $optionValue }}" {{ $selected == $optionValue ? 'selected' : '' }}>
                {{ $optionLabel }}
            </option>
        @endforeach
    </select>
    @error($name)
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

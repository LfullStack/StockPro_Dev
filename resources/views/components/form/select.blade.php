@props(['name', 'label' => '', 'options' => [], 'required' => false])

<div class="form-group">
    <label for="{{ $name }}">{{ $label }}</label>
    <select 
        name="{{ $name }}" 
        id="{{ $name }}" 
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' => 'form-input']) }}
    >
        <option value="">Seleccione una opción</option>
        @foreach($options as $value => $text)
            <option value="{{ $value }}" {{ old($name) == $value ? 'selected' : '' }}>
                {{ $text }}
            </option>
        @endforeach
    </select>
</div>

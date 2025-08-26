@csrf

<div class="mb-4">
    <label for="tipo" class="block font-medium mb-1 ">Tipo</label>
    <select name="tipo" id="tipo" class="form-input">
        <option value="mensual" {{ old('tipo', $meta->tipo ?? '') == 'mensual' ? 'selected' : '' }}>Mensual</option>
        <option value="semanal" {{ old('tipo', $meta->tipo ?? '') == 'semanal' ? 'selected' : '' }}>Semanal</option>
    </select>
</div>

<div class="mb-4">
    <label for="monto_meta" class="block font-medium mb-1">Monto de Meta</label>
    <input type="number" name="monto_meta" class="form-input" value="{{ old('monto_meta', $meta->monto_meta ?? '') }}" required>
</div>

<div class="grid grid-cols-3 gap-4">
    <div>
        <label for="anio" class="block font-medium mb-1">Año</label>
        <input type="number" name="anio" class="form-input" value="{{ old('anio', $meta->anio ?? now()->year) }}" required>
    </div>
    <div>
        <label for="mes" class="block font-medium mb-1">Mes</label>
        <input type="number" name="mes" class="form-input" value="{{ old('mes', $meta->mes ?? now()->month) }}">
    </div>
    <div>
        <label for="semana" class="block font-medium mb-1">Semana</label>
        <input type="number" name="semana" class="form-input" value="{{ old('semana', $meta->semana ?? '') }}">
    </div>
</div>

<!-- Botones -->
                <div class="flex justify-end space-x-2 mt-4">
                    <x-button-link href="{{ route('admin.metas_ventas.index') }}" >Cancelar</x-button-link>
                    <x-button type="submit" >Actualizar</x-button>             
                </div>

document.addEventListener("DOMContentLoaded", () => {
    const productos = @json($productos);
    const container = document.getElementById('items-container');
    const btnAddItem = document.getElementById('add-item');
    const form = document.getElementById('form-factura');

    let index = 0;

    const createItemRow = () => {
        const row = document.createElement('div');
        row.classList.add('grid', 'grid-cols-6', 'gap-4', 'border', 'p-4', 'rounded');

        row.innerHTML = `
            <div class="col-span-2">
                <label class="form-label">Producto</label>
                <select class="form-input producto_id" required>
                    <option value="">Seleccione</option>
                    ${productos.map(p => `<option value="${p.id}">${p.nombre}</option>`).join('')}
                </select>
            </div>
            <div>
                <label class="form-label">Unidad</label>
                <input type="text" class="form-input unidad_medida" required>
            </div>
            <div>
                <label class="form-label">Cantidad</label>
                <input type="number" class="form-input cantidad" min="0.01" step="0.01" required>
            </div>
            <div>
                <label class="form-label">Precio</label>
                <input type="number" class="form-input precio_unitario" min="0" step="0.01" required>
            </div>
            <div>
                <label class="form-label">Descuento</label>
                <input type="number" class="form-input descuento" min="0" value="0">
            </div>
            <div class="col-span-6 text-right">
                <button type="button" class="btn btn-danger remove-item">Eliminar</button>
            </div>
        `;

        row.querySelector('.remove-item').addEventListener('click', () => {
            row.remove();
        });

        container.appendChild(row);
    };

    btnAddItem.addEventListener('click', createItemRow);

    form.addEventListener('submit', (e) => {
        const items = [];
        const rows = container.querySelectorAll('div.grid');

        rows.forEach(row => {
            const producto_id = row.querySelector('.producto_id').value;
            const unidad_medida = row.querySelector('.unidad_medida').value;
            const cantidad = parseFloat(row.querySelector('.cantidad').value);
            const precio_unitario = parseFloat(row.querySelector('.precio_unitario').value);
            const descuento = parseFloat(row.querySelector('.descuento').value || 0);

            const subtotal = cantidad * precio_unitario - descuento;

            items.push({
                producto_id,
                unidad_medida,
                cantidad,
                precio_unitario,
                descuento,
                impuesto: 0,
                subtotal,
            });
        });

        document.getElementById('items-json').value = JSON.stringify(items);
    });
});

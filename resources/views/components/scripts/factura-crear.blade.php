@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const productos = @json($productos);
    const itemsTable = document.getElementById('items-table');
    const tbody = itemsTable.querySelector('tbody');
    const addItemBtn = document.getElementById('add-item');
    const form = document.getElementById('form-factura');
    const itemsJsonInput = document.getElementById('items-json');
    const proveedorSelect = document.querySelector('select[name="proveedor_id"]');

    const subtotalGeneral = document.getElementById('subtotal-general');
    const descuentoGeneral = document.getElementById('descuento-general');
    const impuestoGeneral = document.getElementById('impuesto-general');
    const totalGeneral = document.getElementById('total-general');

    function getProductosDisponibles() {
        const proveedorId = proveedorSelect.value;
        if (!proveedorId) return [];
        return productos.filter(producto => producto.proveedor_id == proveedorId);
    }

    function actualizarSelectsProductos() {
        const productosDisponibles = getProductosDisponibles();
        const hayProductos = productosDisponibles.length > 0;

        document.querySelectorAll('.producto-select').forEach(select => {
            const currentValue = select.value;
            const currentRow = select.closest('tr');

            while (select.options.length > 1) {
                select.remove(1);
            }

            productosDisponibles.forEach(producto => {
                const option = document.createElement('option');
                option.value = producto.id;
                option.textContent = `${producto.nombre}`;
                option.dataset.unidadMedida = producto.unidad_medida.prefijo;
                select.appendChild(option);
            });

            if (currentValue && select.querySelector(`option[value="${currentValue}"]`)) {
                select.value = currentValue;
            } else {
                select.value = '';
                resetRowValues(currentRow);
            }

            select.disabled = !hayProductos;
        });

        updateSummary();
        saveItemsToJson();
    }

    function resetRowValues(row) {
        row.querySelector('.cantidad').value = '1';
        row.querySelector('.unidad-medida').textContent = '';
        row.querySelector('.precio').value = '';
        row.querySelector('.descuento').value = '0';
        row.querySelector('.subtotal').textContent = '$0.00';
    }

    proveedorSelect.addEventListener('change', function() {
        actualizarSelectsProductos();
        if (getProductosDisponibles().length === 0) {
            window.dispatchEvent(new CustomEvent('flux-alert', {
                detail: {
                    message: 'El proveedor seleccionado no tiene productos asociados',
                    type: 'error'
                }
            }));
        }
    });

    function addItemRow(item = null) {
        const row = document.createElement('tr');
        row.className = 'item-row bg-black-500 hover:bg-black-700';

        const productoCell = document.createElement('td');
        productoCell.className = 'px-4 py-2';
        const productoSelect = document.createElement('select');
        productoSelect.className = 'w-full px-3 py-2 bg-gray-700 text-white border border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-gray-500 focus:border-gray-500 producto-select';
        productoSelect.name = 'producto_id[]';
        productoSelect.required = true;

        const emptyOption = document.createElement('option');
        emptyOption.value = '';
        emptyOption.textContent = 'Seleccione un producto';
        emptyOption.className = 'bg-gray-600 text-white';
        productoSelect.appendChild(emptyOption);

        const productosDisponibles = getProductosDisponibles();
        productosDisponibles.forEach(producto => {
            const option = document.createElement('option');
            option.value = producto.id;
            option.textContent = `${producto.nombre}`;
            option.dataset.unidadMedida = producto.unidad_medida.prefijo;
            productoSelect.appendChild(option);
        });

        productoCell.appendChild(productoSelect);

        const unidadCell = document.createElement('td');
        unidadCell.className = 'px-4 py-2 unidad-medida';
        unidadCell.textContent = item ? item.unidad_medida : '';

        const cantidadCell = document.createElement('td');
        cantidadCell.className = 'px-4 py-2';
        const cantidadInput = document.createElement('input');
        cantidadInput.type = 'number';
        cantidadInput.className = 'w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-gray-500 focus:border-gray-500 cantidad';
        cantidadInput.name = 'cantidad[]';
        cantidadInput.step = '0.01';
        cantidadInput.min = '0.01';
        cantidadInput.required = true;
        cantidadInput.value = item ? item.cantidad : '1';
        cantidadCell.appendChild(cantidadInput);

        const precioCell = document.createElement('td');
        precioCell.className = 'px-4 py-2';
        const precioInput = document.createElement('input');
        precioInput.type = 'number';
        precioInput.className = 'w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-gray-500 focus:border-gray-500 precio';
        precioInput.name = 'precio[]';
        precioInput.step = '0.01';
        precioInput.min = '0';
        precioInput.required = true;
        precioInput.value = item ? item.precio_unitario : '';
        precioCell.appendChild(precioInput);

        const descuentoCell = document.createElement('td');
        descuentoCell.className = 'px-4 py-2';
        const descuentoInput = document.createElement('input');
        descuentoInput.type = 'number';
        descuentoInput.className = 'w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-gray-500 focus:border-gray-500 descuento';
        descuentoInput.name = 'descuento[]';
        descuentoInput.step = '1';
        descuentoInput.min = '0';
        descuentoInput.max = '100';
        descuentoInput.value = item ? item.descuento : '0';
        descuentoCell.appendChild(descuentoInput);

        const subtotalCell = document.createElement('td');
        subtotalCell.className = 'px-4 py-2 subtotal';
        subtotalCell.textContent = item ? formatCurrency(item.subtotal) : '$0.00';

        const accionesCell = document.createElement('td');
        accionesCell.className = 'px-4 py-2 text-center';
        const deleteBtn = document.createElement('button');
        deleteBtn.type = 'button';
        deleteBtn.className = 'text-red-600 hover:text-red-800 delete-item';
        deleteBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>';
        accionesCell.appendChild(deleteBtn);

        row.appendChild(productoCell);
        row.appendChild(unidadCell);
        row.appendChild(cantidadCell);
        row.appendChild(precioCell);
        row.appendChild(descuentoCell);
        row.appendChild(subtotalCell);
        row.appendChild(accionesCell);

        tbody.appendChild(row);

        configurarEventosFila(row, deleteBtn);
        productoSelect.dispatchEvent(new Event('change'));

        return row;
    }

    function configurarEventosFila(row, deleteBtn) {
        const productoSelect = row.querySelector('.producto-select');
        const cantidadInput = row.querySelector('.cantidad');
        const precioInput = row.querySelector('.precio');
        const descuentoInput = row.querySelector('.descuento');

        productoSelect.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption.value) {
                const unidadMedida = selectedOption.dataset.unidadMedida;
                row.querySelector('.unidad-medida').textContent = unidadMedida;
            }
            updateItem(row);
        });

        cantidadInput.addEventListener('input', () => updateItem(row));
        precioInput.addEventListener('input', () => updateItem(row));
        descuentoInput.addEventListener('input', () => updateItem(row));

        deleteBtn.addEventListener('click', function () {
            row.remove();
            updateSummary();
            saveItemsToJson();
        });
    }

    function updateItem(row) {
        const cantidad = parseFloat(row.querySelector('.cantidad').value) || 0;
        const precio = parseFloat(row.querySelector('.precio').value) || 0;
        const descuento = parseFloat(row.querySelector('.descuento').value) || 0;

        let subtotal = cantidad * precio;
        const valorDescuento = subtotal * (descuento / 100);
        subtotal -= valorDescuento;
        const impuesto = subtotal * 0.19;

        row.querySelector('.subtotal').textContent = formatCurrency(subtotal);
        updateSummary();
        saveItemsToJson();
    }

    function updateSummary() {
        let subtotal = 0, totalDescuentos = 0, totalImpuestos = 0;

        document.querySelectorAll('.item-row').forEach(row => {
            const cantidad = parseFloat(row.querySelector('.cantidad').value) || 0;
            const precio = parseFloat(row.querySelector('.precio').value) || 0;
            const descuento = parseFloat(row.querySelector('.descuento').value) || 0;

            let itemSubtotal = cantidad * precio;
            const itemDescuento = itemSubtotal * (descuento / 100);
            itemSubtotal -= itemDescuento;
            const itemImpuesto = itemSubtotal * 0.19;

            subtotal += itemSubtotal;
            totalDescuentos += itemDescuento;
            totalImpuestos += itemImpuesto;
        });

        const totalNeto = subtotal + totalImpuestos;

        subtotalGeneral.value = formatCurrency(subtotal);
        descuentoGeneral.value = formatCurrency(totalDescuentos);
        impuestoGeneral.value = formatCurrency(totalImpuestos);
        totalGeneral.value = formatCurrency(totalNeto);
    }

    function saveItemsToJson() {
        const itemsData = [];

        document.querySelectorAll('.item-row').forEach(row => {
            const productoSelect = row.querySelector('.producto-select');
            const productoId = productoSelect.value;
            const productoText = productoSelect.options[productoSelect.selectedIndex].text;
            const unidadMedida = row.querySelector('.unidad-medida').textContent;
            const cantidad = parseFloat(row.querySelector('.cantidad').value) || 0;
            const precio = parseFloat(row.querySelector('.precio').value) || 0;
            const descuento = parseFloat(row.querySelector('.descuento').value) || 0;

            let subtotal = cantidad * precio;
            const valorDescuento = subtotal * (descuento / 100);
            subtotal -= valorDescuento;
            const impuesto = subtotal * 0.19;

            itemsData.push({
                producto_id: productoId,
                producto_nombre: productoText,
                unidad_medida: unidadMedida,
                cantidad,
                precio_unitario: precio,
                descuento,
                subtotal,
                impuesto
            });
        });

        itemsJsonInput.value = JSON.stringify(itemsData);
    }

    function formatCurrency(amount) {
        return '$' + amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
    }

    addItemBtn.addEventListener('click', function () {
        addItemRow();
    });

    form.addEventListener('submit', function(e) {
        if (document.querySelectorAll('.item-row').length === 0) {
            e.preventDefault();
            window.dispatchEvent(new CustomEvent('flux-alert', {
                detail: { message: 'Debe agregar al menos un item a la factura', type: 'error' }
            }));
            return;
        }

        let valid = true;
        document.querySelectorAll('.producto-select').forEach(select => {
            if (!select.value) {
                valid = false;
                select.classList.add('border-red-500');
            } else {
                select.classList.remove('border-red-500');
            }
        });

        if (!valid) {
            e.preventDefault();
            window.dispatchEvent(new CustomEvent('flux-alert', {
                detail: { message: 'Todos los items deben tener un producto seleccionado', type: 'error' }
            }));
            return;
        }

        saveItemsToJson();
    });

    // Carga inicial
    addItemRow();
});
</script>
@endpush

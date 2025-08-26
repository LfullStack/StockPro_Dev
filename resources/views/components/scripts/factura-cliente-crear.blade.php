@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const productos = @json($inventario);
            const itemsTable = document.getElementById('items-table');
            const tbody = itemsTable.querySelector('tbody');
            const addItemBtn = document.getElementById('add-item');
            const form = document.getElementById('form-factura');
            const itemsJsonInput = document.getElementById('items-json');
            const empresaSelect = document.querySelector('select[name="empresa_id"]');
            
            // Elementos de resumen
            const subtotalGeneral = document.getElementById('subtotal-general');
            const descuentoGeneral = document.getElementById('descuento-general');
            const impuestoGeneral = document.getElementById('impuesto-general');
            const totalGeneral = document.getElementById('total-general');
            
            // Elementos de método de pago
            const metodoEfectivo = document.getElementById('metodo-efectivo');
            const metodoDatafono = document.getElementById('metodo-datafono');
            const seccionEfectivo = document.getElementById('seccion-efectivo');
            const montoRecibido = document.getElementById('monto-recibido');
            const cambioCliente = document.getElementById('cambio-cliente');
            
            // Filtrar productos por empresa seleccionada y con stock
            function getProductosDisponibles() {
                const empresaId = empresaSelect.value;
                if (!empresaId) return [];
                
                return productos.filter(producto => 
                    producto.empresa_id == empresaId && producto.cantidad > 0
                );
            }
            
            // Actualizar selects de productos en todas las filas
            function actualizarSelectsProductos() {
                const productosDisponibles = getProductosDisponibles();
                const hayProductos = productosDisponibles.length > 0;
                
                document.querySelectorAll('.producto-select').forEach(select => {
                    const currentValue = select.value;
                    const currentRow = select.closest('tr');
                    
                    // Limpiar opciones excepto la primera vacía
                    while (select.options.length > 1) {
                        select.remove(1);
                    }
                    
                    // Agregar productos disponibles
                    productosDisponibles.forEach(producto => {
                        const option = document.createElement('option');
                        option.value = producto.id;
                        option.textContent = `${producto.producto.nombre} (Stock: ${producto.cantidad})`;
                        option.dataset.unidadMedida = producto.unidad_medida;
                        option.dataset.precio = producto.precio;
                        option.dataset.descuento = producto.descuento;
                        option.dataset.stock = producto.cantidad;
                        option.className = 'bg-gray-700 text-white';
                        select.appendChild(option);
                    });
                    
                    // Restaurar valor seleccionado si existe
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
            
            // Resetear valores de fila cuando no hay producto seleccionado
            function resetRowValues(row) {
                row.querySelector('.cantidad').value = '1';
                row.querySelector('.unidad-medida').textContent = '';
                row.querySelector('.precio').value = '';
                row.querySelector('.descuento').value = '0';
                row.querySelector('.subtotal').textContent = '$0.00';
            }
            
            // Event listener para cambio de empresa
            empresaSelect.addEventListener('change', function() {
                actualizarSelectsProductos();
                
                // Si no hay productos, mostrar alerta
                if (getProductosDisponibles().length === 0) {
                    window.dispatchEvent(new CustomEvent('flux-alert', {
                        detail: {
                            message: 'La empresa seleccionada no tiene productos disponibles',
                            type: 'error' // opciones: success, warning, error
                        }
}));

                }
            });
            
            // Calcular cambio cuando se ingresa monto recibido
            montoRecibido.addEventListener('input', function() {
                const total = parseFloat(totalGeneral.value.replace(/[^0-9.-]+/g,"")) || 0;
                const recibido = parseFloat(this.value) || 0;
                const cambio = recibido - total;
                
                cambioCliente.value = formatCurrency(cambio > 0 ? cambio : 0);
            });
            
            // Función para agregar una nueva fila
            function addItemRow(item = null) {
                const row = document.createElement('tr');
                row.className = 'item-row bg-black-500 hover:bg-black-700';
                
                // Select de productos
                const productoCell = document.createElement('td');
                productoCell.className = 'px-4 py-2';
                const productoSelect = document.createElement('select');
                productoSelect.className = 'w-full px-3 py-2 dark:bg-black-700 dark:text-white border border-white-600 rounded-md shadow-sm focus:outline-none focus:ring-black-500 focus:border-white-500 producto-select';
                productoSelect.name = 'producto_id[]';
                productoSelect.required = true;
                
                // Opción vacía inicial
                const emptyOption = document.createElement('option');
                emptyOption.value = '';
                emptyOption.textContent = 'Seleccione un producto';
                emptyOption.className = 'bg-white-600 dark:text-white';
                productoSelect.appendChild(emptyOption);
                productoCell.appendChild(productoSelect);
                
                // Celda de unidad de medida
                const unidadCell = document.createElement('td');
                unidadCell.className = 'px-4 py-2 unidad-medida';
                unidadCell.textContent = item ? item.unidad_medida : '';
                
                // Celda de cantidad
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
                
                // Celda de precio
                const precioCell = document.createElement('td');
                precioCell.className = 'px-4 py-2';
                const precioInput = document.createElement('input');
                precioInput.type = 'number';
                precioInput.className = 'w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-gray-500 focus:border-gray-500 precio';
                precioInput.name = 'precio[]';
                precioInput.step = '0.01';
                precioInput.min = '0';
                precioInput.readOnly = true;
                precioInput.required = true;
                precioInput.value = item ? item.precio_unitario : '';
                precioCell.appendChild(precioInput);
                
                // Celda de descuento
                const descuentoCell = document.createElement('td');
                descuentoCell.className = 'px-4 py-2';
                const descuentoInput = document.createElement('input');
                descuentoInput.type = 'number';
                descuentoInput.className = 'w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-gray-500 focus:border-gray-500 descuento';
                descuentoInput.name = 'descuento[]';
                descuentoInput.step = '1';
                descuentoInput.min = '0';
                descuentoInput.max = '100';
                descuentoInput.readOnly= true;
                descuentoInput.value = item ? item.descuento : '0';
                descuentoCell.appendChild(descuentoInput);
                
                // Celda de subtotal
                const subtotalCell = document.createElement('td');
                subtotalCell.className = 'px-4 py-2 subtotal';
                subtotalCell.textContent = item ? formatCurrency(item.subtotal) : '$0.00';
                
                // Celda de acciones
                const accionesCell = document.createElement('td');
                accionesCell.className = 'px-4 py-2 text-center';
                const deleteBtn = document.createElement('button');
                deleteBtn.type = 'button';
                deleteBtn.className = 'text-red-600 hover:text-red-800 delete-item';
                deleteBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>';
                accionesCell.appendChild(deleteBtn);
                
                // Ensamblar la fila
                row.appendChild(productoCell);
                row.appendChild(unidadCell);
                row.appendChild(cantidadCell);
                row.appendChild(precioCell);
                row.appendChild(descuentoCell);
                row.appendChild(subtotalCell);
                row.appendChild(accionesCell);
                
                tbody.appendChild(row);
                
                // Configurar eventos para la nueva fila
                configurarEventosFila(row);
                
                // Actualizar select de productos para la nueva fila
                actualizarSelectsProductos();
                
                return row;
            }
            
            // Configurar eventos para una fila
            function configurarEventosFila(row) {
                const productoSelect = row.querySelector('.producto-select');
                const cantidadInput = row.querySelector('.cantidad');
                const precioInput = row.querySelector('.precio');
                const descuentoInput = row.querySelector('.descuento');
                
                productoSelect.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    if (selectedOption.value) {
                        const unidadMedida = selectedOption.dataset.unidadMedida;
                        const precio = selectedOption.dataset.precio;
                        const descuento = selectedOption.dataset.descuento;
                        const stock = selectedOption.dataset.stock;
                        
                        row.querySelector('.unidad-medida').textContent = unidadMedida;
                        precioInput.value = precio;
                        descuentoInput.value = descuento;
                        cantidadInput.setAttribute('max', stock);
                        
                        // Mostrar alerta si el stock es bajo
                        if (stock < 5) {                            
                            window.dispatchEvent(new CustomEvent('flux-alert', {
                                detail: {
                                    message: `¡Atención! Stock bajo para ${selectedOption.text.split(' (Stock')[0]}. Solo quedan ${stock} unidades.`,
                                    type: 'error'
                                }
                        }));

                        }
                        
                        if (stock < 10) {                            
                            window.dispatchEvent(new CustomEvent('flux-alert', {
                                detail: {
                                    message: `¡Atención! Stock bajo para ${selectedOption.text.split(' (Stock')[0]}. Solo quedan ${stock} unidades.`,
                                    type: 'warning'
                                }
                        }));

                        }
                    }
                    updateItem(row);
                });
                
                cantidadInput.addEventListener('input', () => updateItem(row));
                precioInput.addEventListener('input', () => updateItem(row));
                descuentoInput.addEventListener('input', () => updateItem(row));
                
                row.querySelector('.delete-item').addEventListener('click', function() {
                    row.remove();
                    updateSummary();
                    saveItemsToJson();
                });
            }
            
            // Función para actualizar los cálculos de un ítem
            function updateItem(row) {
                const cantidad = parseFloat(row.querySelector('.cantidad').value) || 0;
                const precio = parseFloat(row.querySelector('.precio').value) || 0;
                const descuento = parseFloat(row.querySelector('.descuento').value) || 0;
                
                // Calcular subtotal con descuento
                let subtotal = cantidad * precio;
                const valorDescuento = subtotal * (descuento / 100);
                subtotal -= valorDescuento;
                
                // Calcular impuesto (19% del subtotal)
                const impuesto = subtotal * 0.19;
                
                // Mostrar subtotal (con impuesto incluido)
                row.querySelector('.subtotal').textContent = formatCurrency(subtotal);
                
                // Actualizar resumen
                updateSummary();
                saveItemsToJson();
            }
            
            // Función para actualizar el resumen general
            function updateSummary() {
                let subtotal = 0;
                let totalDescuentos = 0;
                let totalImpuestos = 0;
                
                document.querySelectorAll('.item-row').forEach(row => {
                    const cantidad = parseFloat(row.querySelector('.cantidad').value) || 0;
                    const precio = parseFloat(row.querySelector('.precio').value) || 0;
                    const descuento = parseFloat(row.querySelector('.descuento').value) || 0;
                    
                    let itemSubtotal = cantidad * precio;
                    const itemDescuento = itemSubtotal * (descuento / 100);
                    itemSubtotal -= itemDescuento;
                    
                    const itemImpuesto = itemSubtotal * 0.19;
                    
                    subtotal += itemSubtotal;
                    subtotal = subtotal-itemImpuesto;
                    totalDescuentos += itemDescuento;
                    totalImpuestos += itemImpuesto;
                });
                
                const totalNeto = subtotal + totalImpuestos;
                
                subtotalGeneral.value = formatCurrency(subtotal);
                descuentoGeneral.value = formatCurrency(totalDescuentos);
                impuestoGeneral.value = formatCurrency(totalImpuestos);
                totalGeneral.value = formatCurrency(totalNeto);
                
                // Actualizar el cambio si hay monto recibido
                if (metodoEfectivo.checked && montoRecibido.value) {
                    const recibido = parseFloat(montoRecibido.value) || 0;
                    const cambio = recibido - totalNeto;
                    cambioCliente.value = formatCurrency(cambio > 0 ? cambio : 0);
                }
            }
            
            // Función para guardar los items en el input hidden como JSON
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
                        producto_nombre: productoText.split(' (Stock')[0],
                        unidad_medida: unidadMedida,
                        cantidad: cantidad,
                        precio_unitario: precio,
                        descuento: descuento,
                        impuesto: impuesto,
                        subtotal: subtotal + impuesto
                    });
                });
                
                itemsJsonInput.value = JSON.stringify(itemsData);
            }
            
            // Función para formatear moneda
            function formatCurrency(amount) {
                return '$' + amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
            }
            
            // Event listener para agregar nuevo ítem
            addItemBtn.addEventListener('click', function() {
                // Verificar si hay productos disponibles antes de agregar
                if (getProductosDisponibles().length === 0) {
                    window.dispatchEvent(new CustomEvent('flux-alert', {
                        detail: {
                            message: 'No hay productos disponibles para esta empresa',
                            type: 'error' // opciones: success, warning, error
                        }
                }));

                }
                
                addItemRow();
            });
            
            // Event listener para el formulario
            form.addEventListener('submit', function(e) {
                // Validar que haya al menos un ítem
                if (document.querySelectorAll('.item-row').length === 0) {
                    e.preventDefault();
                    window.dispatchEvent(new CustomEvent('flux-alert', {
                        detail: {
                            message: 'Debe agregar al menos un item a la factura',
                            type: 'error' // opciones: success, warning, error
                        }
                }));
                    return;
                }
                
                // Validar que todos los ítems tengan producto seleccionado
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
                        detail: {
                            message: 'Todos los items deben tener un producto seleccionado',
                            type: 'error' // opciones: success, warning, error
                        }
                    }));
                    return;
                }
                
                // Validar método de pago si es efectivo
                if (metodoEfectivo.checked) {
                    const total = parseFloat(totalGeneral.value.replace(/[^0-9.-]+/g,"")) || 0;
                    const recibido = parseFloat(montoRecibido.value) || 0;
                    
                    if (recibido < total) {
                        e.preventDefault();
                        window.dispatchEvent(new CustomEvent('flux-alert', {
                        detail: {
                            message: 'El monto recibido debe ser mayor al de la factura',
                            type: 'error' // opciones: success, warning, error
                        }
                    }));
                        return;
                    }
                }
                
                saveItemsToJson();
            });
            
            // Event listeners para método de pago
            metodoEfectivo.addEventListener('change', function() {
                seccionEfectivo.style.display = this.checked ? 'grid' : 'none';
            });
            
            metodoDatafono.addEventListener('change', function() {
                seccionEfectivo.style.display = 'none';
            });
            
            // Agregar una fila vacía al cargar la página
            addItemRow();
        });
    </script>
    @endpush
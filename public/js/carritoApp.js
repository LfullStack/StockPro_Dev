document.addEventListener('alpine:init', () => {
    Alpine.data('carritoApp', () => ({
        modales: {
            cliente: false,
            pago: false
        },
        direccion: {
            departamento: '',
            municipio: '',
            direccion: '',
            telefono: ''
        },
        metodoPago: '',
        mostrarConfirmacionSalir: false,
        carrito: JSON.parse(document.querySelector('meta[name="carrito-data"]').content),
        total: document.querySelector('meta[name="total-data"]').content,

        init() {
            // Código que se ejecuta al inicializar el componente
            console.log('Componente carritoApp inicializado');
        },

        abrirClienteModal() {
            this.modales.cliente = true;
        },

        abrirPagoModal() {
            this.modales.cliente = false;
            this.modales.pago = true;
        },

        cerrarModales() {
            this.modales.cliente = false;
            this.modales.pago = false;
        },

        renderPayPal() {
            setTimeout(() => {
                const container = document.getElementById('paypal-button-container');
                if (container && container.children.length === 0) {
                    paypal.Buttons({
                        createOrder: (data, actions) => {
                            return actions.order.create({
                                purchase_units: [{
                                    amount: { value: this.total }
                                }]
                            });
                        },
                        onApprove: (data, actions) => {
                            return actions.order.capture().then(details => {
                                const payload = new URLSearchParams({
                                    orderID: data.orderID,
                                    direccion: JSON.stringify(this.direccion),
                                    carrito: JSON.stringify(this.carrito),
                                    total: this.total
                                });
                                window.location.href = `/paypal/success?${payload.toString()}`;
                            });
                        }
                    }).render('#paypal-button-container');
                }
            }, 300);
        }
    }));
});

    $(document).ready(function() {
      // Simulador de carga
      setTimeout(function() {
        $("#loadingOverlay").fadeOut();
      }, 1500);
      
      // Funcionalidad de cambio de tema
      const themeToggle = document.getElementById('themeToggle');
      const themeIcon = themeToggle.querySelector('i');

      // Verificar si el usuario ha seleccionado previamente un tema
      const currentTheme = localStorage.getItem('theme');
      if (currentTheme === 'light') {
        document.body.classList.add('light-theme');
        themeIcon.classList.remove('fa-moon');
        themeIcon.classList.add('fa-sun');
      }
      
      
      // Cambiar tema al hacer clic en el botón
      $('a[href^="#"]').on('click', function(event) {
        if (this.hash !== '') {
          event.preventDefault();
          const hash = this.hash;
          $('html, body').animate({
            scrollTop: $(hash).offset().top - 70
          }, 800);
        }
      });
      
      // Manejador de eventos para el desplazamiento de la ventana
      $(window).scroll(function() {
        if ($(this).scrollTop() > 300) {
          $('#backToTop').addClass('visible');
        } else {
          $('#backToTop').removeClass('visible');
        }
      });
      
      $('#backToTop').click(function() {
        $('html, body').animate({scrollTop: 0}, 800);
        return false;
      });
      
      // Manejador de eventos para el cambio de tema
      $('#decreaseQuantity').click(function() {
        const currentVal = parseInt($('#quantity').val());
        if (currentVal > 1) {
          $('#quantity').val(currentVal - 1);
        }
      });
      
      $('#increaseQuantity').click(function() {
        const currentVal = parseInt($('#quantity').val());
        if (currentVal < 10) {
          $('#quantity').val(currentVal + 1);
        }
      });
      
      // Manejador de eventos para el modal de compra
      $('#purchaseModal').on('show.bs.modal', function(event) {
          const button = $(event.relatedTarget);
          const product = button.data("product");
          const price = button.data("price");

          // Actualizar el contenido del modal
          const modal = $(this);
          modal.find("#modalProductName").text(product);

          // Condicionar el precio del producto
          if (price === "Consultar") {
              modal.find("#modalProductPrice").text("Precio: A consultar");
          } else {
              modal.find("#modalProductPrice").text(`$${price}/mes`);
          }

          // Actualizar la imagen del producto
          let imageSrc = "";
          switch (product) {
              case "Plan Básico":
                  imageSrc =
                      "https://cdn.pixabay.com/photo/2015/07/17/22/42/startup-849804_1280.jpg";
                  break;
              case "Plan Profesional":
                  imageSrc =
                      "{{asset('img/planpro.jpg')}}";
                  break;
              case "Plan Empresarial":
                  imageSrc =
                      "https://cdn.pixabay.com/photo/2017/07/31/11/44/laptop-2557576_1280.jpg";
                  break;
              case "Plan Personalizado":
                  imageSrc =
                      "https://cdn.pixabay.com/photo/2018/03/10/09/45/businessman-3213659_1280.jpg";
                  break;
              default:
                  imageSrc =
                      "https://cdn.pixabay.com/photo/2015/07/17/22/42/startup-849804_1280.jpg";
          }

          modal.find("#modalProductImage").attr("src", imageSrc);
      });
      
      
      
      
      // Initialize tooltips
      const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
      const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
      });
    });

document.addEventListener('DOMContentLoaded', function () {
  const modal = document.getElementById('purchaseModal');

  modal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;

    // Obtiene los datos del botón
    const product = button.getAttribute('data-product');
    const price = button.getAttribute('data-price');

    // Opcional: obtener la imagen del producto desde el card
    const card = button.closest('.product-card');
    const imgSrc = card.querySelector('img').getAttribute('src');

    // Inserta los valores en el modal
    modal.querySelector('#modalProductName').textContent = product;
    modal.querySelector('#modalProductPrice').textContent = price === 'Consultar' ? 'Consultar' : `$${price}/mes`;
    modal.querySelector('#modalProductImage').setAttribute('src', imgSrc);
  });
});

// Función para inicializar el modal de compra
document.addEventListener('DOMContentLoaded', function () {
  const buttons = document.querySelectorAll('[data-bs-toggle="modal"]');
  buttons.forEach(button => {
    button.addEventListener('click', function () {
      const plan = this.getAttribute('data-product');
      const price = this.getAttribute('data-price');
      const image = this.closest('.product-card')?.querySelector('img')?.src;

      document.getElementById('modalProductName').textContent = plan;
      document.getElementById('modalProductPrice').textContent = price === 'Consultar' ? 'Consultar' : `$${price}/mes`;
      document.getElementById('modalProductImage').src = image;
      document.getElementById('planInput').value = plan;
      document.getElementById('priceInput').value = price;
    });
  });
});

document.addEventListener('DOMContentLoaded', function () {
  // Asigna evento de envío al formulario
  const form = document.getElementById('purchaseForm');

  form.addEventListener('submit', function (e) {
    e.preventDefault(); // Previene recarga

    const formData = new FormData(form);

    fetch(form.action, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: formData
    })
    .then(response => {
      if (!response.ok) throw new Error('Error en el envío');
      return response.json(); // Si devuelves JSON
    })
    .then(data => {
      // Cerrar modal
      const modal = bootstrap.Modal.getInstance(document.getElementById('purchaseModal'));
      modal.hide();

      // Mostrar mensaje de éxito
      showSuccessAlert('¡Formulario enviado con éxito!');

      // Limpiar formulario
      form.reset();
    })
    .catch(error => {
      console.error(error);
      showErrorAlert('Ocurrió un error al enviar. Intenta nuevamente.');
    });
  });

  function showSuccessAlert(message) {
    const alert = document.createElement('div');
    alert.className = 'alert alert-success position-fixed top-0 end-0 m-4 shadow';
    alert.innerHTML = message;
    document.body.appendChild(alert);
    setTimeout(() => alert.remove(), 4000);
  }

  function showErrorAlert(message) {
    const alert = document.createElement('div');
    alert.className = 'alert alert-danger position-fixed top-0 end-0 m-4 shadow';
    alert.innerHTML = message;
    document.body.appendChild(alert);
    setTimeout(() => alert.remove(), 4000);
  }
});
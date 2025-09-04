<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>StockPro - Inicio</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link id="app-style" href="{{ asset('css/inicio.css') }}" rel="stylesheet">
  <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">


  <script type="importmap">
{
  "imports": {
    "three": "https://unpkg.com/three@0.160.0/build/three.module.js",
    "three/addons/": "https://unpkg.com/three@0.160.0/examples/jsm/"
  }
}
</script>

 <script type="module" src="{{asset('js/logo3d.js')}}"></script>


</head>
<body>
   
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-laravel sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="javascript:void(0)">
                <img src="{{asset('img/logo.png')}}" width="30" height="30" viewBox="0 0 50 52" style="margin-right: 8px;">
                    <path d="M49.626 11.564a.809.809 0 0 1 .028.209v10.972a.8.8 0 0 1-.402.694l-9.209 5.302V39.25c0 .286-.152.55-.4.694L20.42 51.01c-.044.025-.092.041-.14.058-.018.006-.035.017-.054.022a.805.805 0 0 1-.41 0c-.022-.006-.042-.018-.063-.026-.044-.016-.09-.03-.132-.054L.402 39.944A.801.801 0 0 1 0 39.25V6.334c0-.072.01-.142.028-.21.006-.023.02-.044.028-.067.015-.042.029-.085.051-.124.015-.026.037-.047.055-.071.023-.032.044-.065.071-.093.023-.023.053-.04.079-.06.029-.024.055-.05.088-.069h.001l9.61-5.533a.802.802 0 0 1 .8 0l9.61 5.533h.002c.032.02.059.045.088.068.026.02.055.038.078.06.028.029.048.062.072.094.017.024.04.045.054.071.023.04.036.082.052.124.008.023.022.044.028.068a.809.809 0 0 1 .028.209v20.559l8.008-4.611v-10.51c0-.07.01-.141.028-.208.007-.024.02-.045.028-.068.016-.042.03-.085.052-.124.015-.026.037-.047.054-.071.024-.032.044-.065.072-.093.023-.023.052-.04.078-.06.03-.024.056-.05.088-.069h.001l9.611-5.533a.801.801 0 0 1 .8 0l9.61 5.533c.034.02.06.045.09.068.025.02.054.038.077.06.028.029.048.062.072.094.018.024.04.045.054.071.023.039.036.082.052.124.009.023.022.044.028.068z" fill="#FF2D20" fill-rule="evenodd"/>
                </svg>
                <span>StockPro</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#Caracteristicas">Características</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#gallery">Galería</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#Testimonios">Testimonios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#Precios">Precios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#Contacto">Contacto</a>
                    </li>
                   
                </ul>
                <div class="ms-3">
                    <a href="/login" class="btn btn-outline-laravel">Iniciar Sesión</a>
                </div>
            </div>
        </div>
    </nav>
<!---------------------------------HERO SECTION--------------------------------->
 <!-- Hero Section Principal-->
  <section class="hero-section" id="hero">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6 hero-text">
          <h2><strong>Controla tu <em class="text-danger">Inventario</em> En Tiempo Real, Fácil y Rápido</strong></h2>
          <p>Nuestro software en la nube te ayuda a gestionar productos, proveedores y ventas desde cualquier dispositivo.</p>
          <a href="#Precios" class="btn btn-laravel btn-lg">Solicitar Plan</a>
        </div>
        <div class="col-lg-6 d-none d-lg-block">
          <div id="logo3d" style="width: 100%; height: 400px;"></div>
        </div>
      </div>
    </div>
  </section>


    <!-- Stats Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-6 mb-4 mb-md-0">
                    <div class="stats-container">
                        <div class="stats-number">100%</div>
                        <p class="mb-0">Escalabilidad</p>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-4 mb-md-0">
                    <div class="stats-container">
                        <div class="stats-number">99.9%</div>
                        <p class="mb-0">Tiempo de Actividad</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stats-container">
                        <div class="stats-number">30%</div>
                        <p class="mb-0">Aumento de Eficiencia</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stats-container">
                        <div class="stats-number">24/7</div>
                        <p class="mb-0">Soporte Técnico</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5 bg-light" id="Caracteristicas">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-6 mx-auto text-center">
                    <h2 class="section-title text-center mb-3">Características Principales</h2>
                    <p class="text-muted">Nuestro sistema de gestión de inventario ha sido diseñado para optimizar tus operaciones y maximizar la eficiencia de tu negocio.</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card p-4 h-100">
                        <div class="icon">
                            <i class="fas fa-box"></i>
                        </div>
                        <h3 class="card-title h5">Control de Inventario en Tiempo Real</h3>
                        <p class="text-muted">Monitorea tu inventario al instante con actualizaciones automáticas cuando se realizan cambios.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card p-4 h-100">
                        <div class="icon">
                            <i class="fas fa-bell"></i>
                        </div>
                        <h3 class="card-title h5">Alertas de Bajo Stock</h3>
                        <p class="text-muted">Recibe notificaciones automáticas cuando tus productos alcancen niveles críticos de inventario.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card p-4 h-100">
                        <div class="icon">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <h3 class="card-title h5">Reportes Analíticos Avanzados</h3>
                        <p class="text-muted">Visualiza datos importantes con gráficos intuitivos para tomar decisiones informadas.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card p-4 h-100">
                        <div class="icon">
                            <i class="fas fa-barcode"></i>
                        </div>
                        <h3 class="card-title h5">Escaneo de Código de Barras</h3>
                        <p class="text-muted">Integración con lectores de código de barras para una gestión más rápida y sin errores.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card p-4 h-100">
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3 class="card-title h5">Gestión de Usuarios y Permisos</h3>
                        <p class="text-muted">Controla quién tiene acceso a diferentes partes del sistema con roles personalizables.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card p-4 h-100">
                        <div class="icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <h3 class="card-title h5">Compatible con Dispositivos Móviles</h3>
                        <p class="text-muted">Accede a tu inventario desde cualquier lugar con nuestra interfaz totalmente responsive.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section class="py-5" id="gallery">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-6 mx-auto text-center">
                    <h2 class="section-title text-center mb-3">Galería de Imágenes</h2>
                    <p class="text-muted">Explora las capturas de pantalla de nuestro sistema en acción.</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100">
                        <img src="{{asset('img/estadisticas.png')}}" alt="Placeholder" class="card-img-top img-fluid">
                        <div class="card-body">
                            <p class="card-text text-center">Dashboard principal con estadísticas de inventario.</p>
                        </div>
                    </div>
                </div>
                 <div class="col-md-4">
                    <div class="card h-100">
                        <img src="{{asset('img/dashboard.png')}}" alt="Placeholder" class="card-img-top img-fluid">
                        <div class="card-body">
                            <p class="card-text text-center">Vista móvil de la aplicación.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100">
                        <img src="{{asset('img/items.png')}}" alt="Placeholder" class="card-img-top img-fluid">
                        <div class="card-body">
                            <p class="card-text text-center">Interfaz de gestión de productos detallada.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100">
                        <img src="{{asset('img/notificaciones.png')}}" alt="Placeholder" class="card-img-top img-fluid">
                        <div class="card-body">
                            <p class="card-text text-center">Reportes gráficos personalizables.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100">
                        <img src="{{asset('img/users.png')}}" alt="Placeholder" class="card-img-top img-fluid">
                        <div class="card-body">
                            <p class="card-text text-center">Gestión de usuarios y permisos.</p>
                        </div>
                    </div>
                </div>
               
                <div class="col-md-4">
                    <div class="card h-100">
                        <img src="{{asset('img/posts.png')}}" alt="Placeholder" class="card-img-top img-fluid">
                        <div class="card-body">
                            <p class="card-text text-center">Configuración de alertas y notificaciones.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Dashboard Preview -->
    <section class="py-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-6">
                    <h2 class="section-title">Panel de Control Intuitivo</h2>
                    <p class="text-muted mb-4">Nuestro dashboard te brinda una visión general de tu inventario con métricas clave y acciones rápidas para una gestión eficiente.</p>
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-3 text-laravel">
                                <i class="fas fa-check-circle fa-lg" style="color: #FF2D20;"></i>
                            </div>
                            <div>
                                <h4 class="h6 mb-0">Resumen de inventario en tiempo real</h4>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-3">
                                <i class="fas fa-check-circle fa-lg" style="color: #FF2D20;"></i>
                            </div>
                            <div>
                                <h4 class="h6 mb-0">Gráficos de movimiento de inventario</h4>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-3">
                                <i class="fas fa-check-circle fa-lg" style="color: #FF2D20;"></i>
                            </div>
                            <div>
                                <h4 class="h6 mb-0">Alertas y notificaciones centralizadas</h4>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-check-circle fa-lg" style="color: #FF2D20;"></i>
                            </div>
                            <div>
                                <h4 class="h6 mb-0">Acceso rápido a funciones principales</h4>
                            </div>
                        </div>
                    </div>
                    <a href="{{asset('img/dashboard.png')}}" class="btn btn-laravel">Explorar Dashboard</a>
                </div>
                <div class="col-lg-6 mt-5 mt-lg-0">
                    <div class="screenshot-container">
                        <!-- Aquí va la imagen del dashboard -->
                        <img src="{{asset('img/dashboard_sidebar.png')}}" alt="Dashboard de InventarioPro" class="img-fluid screenshot-desktop">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mobile Experience -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-6 mx-auto text-center">
                    <h2 class="section-title text-center">Experiencia Móvil Completa</h2>
                    <p class="text-muted">Gestiona tu inventario desde cualquier lugar con nuestra aplicación móvil completamente funcional.</p>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-lg-5 order-lg-2">
                    <div class="text-center text-lg-start">
                        <img src="https://cdn.pixabay.com/photo/2017/01/22/12/07/imac-1999636_1280.png" alt="InventarioPro Móvil" class="img-fluid" style="max-height: 500px;">
                    </div>
                </div>
                <div class="col-lg-7 order-lg-1 mt-5 mt-lg-0">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="feature-card p-4">
                                <div class="icon">
                                    <i class="fas fa-sync-alt"></i>
                                </div>
                                <h3 class="card-title h5">Sincronización en Tiempo Real</h3>
                                <p class="text-muted">Los cambios se sincronizan instantáneamente entre todos los dispositivos.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="feature-card p-4">
                                <div class="icon">
                                    <i class="fas fa-camera"></i>
                                </div>
                                <h3 class="card-title h5">Escáner Integrado</h3>
                                <p class="text-muted">Usa la cámara de tu dispositivo como lector de códigos de barras.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="feature-card p-4">
                                <div class="icon">
                                    <i class="fas fa-bell"></i>
                                </div>
                                <h3 class="card-title h5">Notificaciones Push</h3>
                                <p class="text-muted">Recibe alertas importantes directamente en tu dispositivo.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="feature-card p-4">
                                <div class="icon">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <h3 class="card-title h5">Acceso Seguro</h3>
                                <p class="text-muted">Autenticación biométrica para mayor seguridad.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How it Works -->
    <section class="py-5 how-it-works">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-6 mx-auto text-center">
                    <h2 class="section-title text-center">Cómo Funciona</h2>
                    <p class="text-muted">Implementar nuestro sistema de gestión de inventario es sencillo y rápido.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="step">
                        <div class="step-number">1</div>
                        <h3 class="h5 mb-3">Configura tu cuenta</h3>
                        <p class="text-muted">Crea tu cuenta y personaliza la configuración según las necesidades específicas de tu negocio.</p>
                    </div>
                    <div class="step">
                        <div class="step-number">2</div>
                        <h3 class="h5 mb-3">Importa tu inventario existente</h3>
                        <p class="text-muted">Importa fácilmente tus datos desde Excel, CSV o sistemas existentes con nuestras herramientas de migración.</p>
                    </div>
                    <div class="step">
                        <div class="step-number">3</div>
                        <h3 class="h5 mb-3">Configura categorías y alertas</h3>
                        <p class="text-muted">Organiza tus productos en categorías y establece niveles de alerta para un control óptimo.</p>
                    </div>
                    <div class="step">
                        <div class="step-number">4</div>
                        <h3 class="h5 mb-3">¡Comienza a gestionar tu inventario!</h3>
                        <p class="text-muted">Aprovecha todas las funciones para optimizar la gestión de tu inventario y mejorar la eficiencia operativa.</p>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-lg-6 mx-auto text-center">
                    <a href="javascript:void(0)" class="btn btn-laravel">Comenzar Ahora</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="py-5 bg-light" id="Testimonios">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-6 mx-auto text-center">
                    <h2 class="section-title text-center">Lo Que Dicen Nuestros Clientes</h2>
                    <p class="text-muted">Empresas de todos los tamaños confían en nuestro sistema para gestionar su inventario.</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="testimonial">
                        <p class="mb-4">"InventarioPro ha transformado la manera en que gestionamos nuestro almacén. Ahora tenemos visibilidad total de nuestro inventario y hemos reducido los errores en un 95%."</p>
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="rounded-circle bg-white d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <span class="fw-bold" style="color: var(--dark-bg);">MR</span>
                                </div>
                            </div>
                            <div class="ms-3">
                                <h5 class="h6 mb-0">María Rodríguez</h5>
                                <p class="mb-0 small company">Distribuidora Nacional S.A.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="testimonial">
                        <p class="mb-4">"La integración fue sorprendentemente rápida y el sistema es muy intuitivo. Nuestro equipo lo adoptó sin problemas y ahora no podríamos vivir sin él."</p>
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="rounded-circle bg-white d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <span class="fw-bold" style="color: var(--dark-bg);">JG</span>
                                </div>
                            </div>
                            <div class="ms-3">
                                <h5 class="h6 mb-0">Jose Quintero</h5>
                                <p class="mb-0 small company">PhoneMasters</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing -->
    <section class="py-5" id="Precios">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-6 mx-auto text-center">
                    <h2 class="section-title text-center">Planes Flexibles Para Tu Negocio</h2>
                    <p class="text-muted">Elige el plan que mejor se adapte a las necesidades de tu empresa.</p>
                </div>
            </div>
            <div class="row g-4 justify-content-center">
                <div class="col-lg-4 col-md-6">
                    <div class="pricing-card">
                        <div class="pricing-header text-center">
                            <h3>Plan Básico</h3>
                        </div>
                        <div class="p-4 text-center">
                            <div class="price">$29<small>/mes</small></div>
                            <p class="text-muted mb-4">Para pequeñas empresas</p>
                            <ul class="list-unstyled text-start mb-4">
                                <li class="mb-2"><i class="fas fa-check me-2" style="color: var(--laravel-red);"></i>Hasta 1,000 productos</li>
                                <li class="mb-2"><i class="fas fa-check me-2" style="color: var(--laravel-red);"></i>2 usuarios</li>
                                <li class="mb-2"><i class="fas fa-check me-2" style="color: var(--laravel-red);"></i>Reportes básicos</li>
                                <li class="mb-2"><i class="fas fa-check me-2" style="color: var(--laravel-red);"></i>Soporte por email</li>
                                <li class="mb-2 text-muted"><i class="fas fa-times me-2"></i>API acceso</li>
                                <li class="text-muted"><i class="fas fa-times me-2"></i>Integraciones avanzadas</li>
                            </ul>
                            <a href="javascript:void(0)" class="btn btn-outline-laravel">Seleccionar Plan</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="pricing-card popular-plan">
                        <div class="pricing-header text-center">
                            <h3>Plan Profesional</h3>
                            <span class="badge bg-white text-dark mt-2">Más Popular</span>
                        </div>
                        <div class="p-4 text-center">
                            <div class="price">$79<small>/mes</small></div>
                            <p class="text-muted mb-4">Para empresas en crecimiento</p>
                            <ul class="list-unstyled text-start mb-4">
                                <li class="mb-2"><i class="fas fa-check me-2" style="color: var(--laravel-red);"></i>Hasta 10,000 productos</li>
                                <li class="mb-2"><i class="fas fa-check me-2" style="color: var(--laravel-red);"></i>5 usuarios</li>
                                <li class="mb-2"><i class="fas fa-check me-2" style="color: var(--laravel-red);"></i>Reportes avanzados</li>
                                <li class="mb-2"><i class="fas fa-check me-2" style="color: var(--laravel-red);"></i>Soporte prioritario</li>
                                <li class="mb-2"><i class="fas fa-check me-2" style="color: var(--laravel-red);"></i>API acceso</li>
                                <li class="text-muted"><i class="fas fa-times me-2"></i>Integraciones avanzadas</li>
                            </ul>
                            <a href="javascript:void(0)" class="btn btn-laravel">Seleccionar Plan</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="pricing-card">
                        <div class="pricing-header text-center">
                            <h3>Plan Empresarial</h3>
                        </div>
                        <div class="p-4 text-center">
                            <div class="price">$199<small>/mes</small></div>
                            <p class="text-muted mb-4">Para grandes empresas</p>
                            <ul class="list-unstyled text-start mb-4">
                                <li class="mb-2"><i class="fas fa-check me-2" style="color: var(--laravel-red);"></i>Productos ilimitados</li>
                                <li class="mb-2"><i class="fas fa-check me-2" style="color: var(--laravel-red);"></i>Usuarios ilimitados</li>
                                <li class="mb-2"><i class="fas fa-check me-2" style="color: var(--laravel-red);"></i>Reportes personalizados</li>
                                <li class="mb-2"><i class="fas fa-check me-2" style="color: var(--laravel-red);"></i>Soporte 24/7</li>
                                <li class="mb-2"><i class="fas fa-check me-2" style="color: var(--laravel-red);"></i>API acceso</li>
                                <li><i class="fas fa-check me-2" style="color: var(--laravel-red);"></i>Integraciones avanzadas</li>
                            </ul>
                            <a href="javascript:void(0)" class="btn btn-outline-laravel">Seleccionar Plan</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="pricing-card">
                        <div class="pricing-header text-center">
                            <h3>Plan Personalizado</h3>
                        </div>
                        <div class="p-4 text-center ">
                            <div class="price">A medida</div>
                            <p class="text-muted mb-4">Diseñado para necesidades específicas de tu empresa</p>
                            <ul class="list-unstyled text-start mb-4">
                                <li class="mb-2"><i class="fas fa-check me-2" style="color: var(--laravel-red);"></i>Productos ilimitados</li>
                                <li class="mb-2"><i class="fas fa-check me-2" style="color: var(--laravel-red);"></i>Usuarios ilimitados</li>
                                <li class="mb-2"><i class="fas fa-check me-2" style="color: var(--laravel-red);"></i>Reportes personalizados</li>
                                <li><i class="fas fa-check me-2" style="color: var(--laravel-red);"></i>Integraciones a medida</li>
                            </ul>
                            <a href="javascript:void(0)" class="btn btn-laravel">Contáctanos</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-5 bg-dark text-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 mb-4 mb-lg-0">
                    <h2 class="mb-3">¿Listo para optimizar tu gestión de inventario?</h2>
                    <p class="mb-0">Comienza hoy con una prueba gratuita de 14 días. Sin compromisos ni tarjeta de crédito.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="/login" class="btn btn-laravel btn-lg">Iniciar Sesión</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="py-5 bg-dark text-white" id="benefits">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-6 mx-auto text-center">
                    <h2 class="section-title text-center">¿Por qué elegir StockPro?</h2>
                    <p class="text-light">Descubre por qué somos la opción preferida para la gestión de inventario.</p>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="text-center">
                        <img src="{{asset('img/fondo4.png')}}" alt="Placeholder" class="img-fluid rounded" style="max-height: 400px;">
                    </div>
                </div>
                <div class="col-lg-6">
                    <ul class="list-unstyled">
                        <li class="mb-4">
                            <div class="d-flex">
                                <div class="me-3">
                                    <i class="fas fa-shield-alt fa-2x" style="color: var(--laravel-red);"></i>
                                </div>
                                <div>
                                    <h4>Seguridad Avanzada</h4>
                                    <p class="text-light">Protección de datos con cifrado de extremo a extremo y autenticación de múltiples factores para garantizar la integridad de tu información.</p>
                                </div>
                            </div>
                        </li>
                        <li class="mb-4">
                            <div class="d-flex">
                                <div class="me-3">
                                    <i class="fas fa-expand-arrows-alt fa-2x" style="color: var(--laravel-red);"></i>
                                </div>
                                <div>
                                    <h4>Escalabilidad Total</h4>
                                    <p class="text-light">Nuestra plataforma crece con tu negocio, desde pequeñas tiendas hasta grandes cadenas multinacionales sin perder rendimiento.</p>
                                </div>
                            </div>
                        </li>
                        <li class="mb-4">
                            <div class="d-flex">
                                <div class="me-3">
                                    <i class="fas fa-headset fa-2x" style="color: var(--laravel-red);"></i>
                                </div>
                                <div>
                                    <h4>Soporte Dedicado</h4>
                                    <p class="text-light">Equipo de especialistas disponible 24/7 para resolver cualquier duda o incidencia con tiempos de respuesta garantizados.</p>
                                </div>
                            </div>
                        </li>
                        <li class="mb-4">
                            <div class="d-flex">
                                <div class="me-3">
                                    <i class="fas fa-code fa-2x" style="color: var(--laravel-red);"></i>
                                </div>
                                <div>
                                    <h4>API Robusta</h4>
                                    <p class="text-light">Integración sencilla con tus sistemas existentes a través de nuestra API bien documentada y flexible.</p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Developers Section -->
    <section class="py-5 bg-dark text-white">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-6 mx-auto text-center">
                    <h2 class="section-title text-center">Nuestros Desarrolladores</h2>
                    <p class="text-light">Conoce al equipo que hace posible StockPro.</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="text-center mb-4">
                        <img src="{{asset('img/gilson.jpg')}}" alt="Developer 1" class="rounded-circle img-fluid mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                        <h3 class="h4 fw-bold">Gilson Zuñiga M.</h3>
                        <p class="text-ligth mb-3">Tecnólogo en Análisis y Desarrollo de Software</p>
                        <p>Tuvo a su cargo la estructuración y gestión de la base de datos, asegurando un modelo sólido y eficiente para el almacenamiento y consulta de la información. En el backend trabajó en la creación de controladores y definición de rutas, implementando la lógica necesaria para conectar la capa de datos con la aplicación. Su trabajo garantizó la correcta comunicación entre el sistema y la base de datos, así como la consistencia e integridad de la información..</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="text-center mb-4">
                        <img src="{{asset('img/levi.jpg')}}" alt="Developer 2" class="rounded-circle img-fluid mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                        <h3 class="h4 fw-bold">Levi J. Quintero S.</h3>
                        <p class="text-ligth mb-3">Tecnólogo en Análisis y Desarrollo de Software</p>
                        <p>Se encargó de la implementación y despliegue del proyecto en un entorno de nube, asegurando la correcta configuración de la infraestructura y la disponibilidad de la aplicación. En la parte de backend trabajó en la gestión de usuarios, definición de rutas y control de accesos, garantizando un flujo seguro y eficiente de la información. También participó en el desarrollo del frontend, integrando las vistas con la lógica del sistema y optimizando la experiencia de usuario. Su aporte permitió que el proyecto funcionara de manera estable y escalable en producción..</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer py-5" id="Contacto">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <a href="javascript:void(0)" class="d-flex align-items-center mb-3">
                        <img src="{{asset('img/logo.png')}}" width="30" height="30" viewBox="0 0 50 52" style="margin-right: 8px;">
                            <path d="M49.626 11.564a.809.809 0 0 1 .028.209v10.972a.8.8 0 0 1-.402.694l-9.209 5.302V39.25c0 .286-.152.55-.4.694L20.42 51.01c-.044.025-.092.041-.14.058-.018.006-.035.017-.054.022a.805.805 0 0 1-.41 0c-.022-.006-.042-.018-.063-.026-.044-.016-.09-.03-.132-.054L.402 39.944A.801.801 0 0 1 0 39.25V6.334c0-.072.01-.142.028-.21.006-.023.02-.044.028-.067.015-.042.029-.085.051-.124.015-.026.037-.047.055-.071.023-.032.044-.065.071-.093.023-.023.053-.04.079-.06.029-.024.055-.05.088-.069h.001l9.61-5.533a.802.802 0 0 1 .8 0l9.61 5.533h.002c.032.02.059.045.088.068.026.02.055.038.078.06.028.029.048.062.072.094.017.024.04.045.054.071.023.04.036.082.052.124.008.023.022.044.028.068a.809.809 0 0 1 .028.209v20.559l8.008-4.611v-10.51c0-.07.01-.141.028-.208.007-.024.02-.045.028-.068.016-.042.03-.085.052-.124.015-.026.037-.047.054-.071.024-.032.044-.065.072-.093.023-.023.052-.04.078-.06.03-.024.056-.05.088-.069h.001l9.611-5.533a.801.801 0 0 1 .8 0l9.61 5.533c.034.02.06.045.09.068.025.02.054.038.077.06.028.029.048.062.072.094.018.024.04.045.054.071.023.039.036.082.052.124.009.023.022.044.028.068z" fill="#FF2D20" fill-rule="evenodd"/>
                        </svg>
                        <span>Stockpro</span>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="social-icon">
                        <a href="https://www.facebook.com/inventario-pro" target="_blank">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    </div>
                    <div class="social-icon">
                        <a href="https://www.instagram.com/inventario_pro" target="_blank">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                    <div class="social-icon">
                        <a href="https://www.linkedin.com/in/inventario-pro" target="_blank">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="social-icon">
                        <a href="quinterolevii87@gmail.com">
                            <i class="fas fa-envelope"></i>
                        </a>
                    </div>
                    <div class="social-icon">
                        <a href="tel:+573243046676">
                            <i class="fas fa-phone"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script id="app-script" src="{{ asset('js/inicio.js') }}"></script>

</body>
</html>

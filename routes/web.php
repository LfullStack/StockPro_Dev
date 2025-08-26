<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\{
    TiendaController,
    CarritoController,
    InicioController,
    DashboardController,
    ContactoController,
    CompraController,
    PayPalController,
    OrdenController,
    RegistroUsuarioController
};

// Página principal
Route::get('/', [InicioController::class, 'index'])->name('home');
Route::get('/home', [InicioController::class, 'index'])->name('inicio.index');

// Tienda
Route::get('/tienda', [TiendaController::class, 'mostrarEcommerce'])->name('tienda.index');
Route::get('/productos', [TiendaController::class, 'mostrarEcommerce'])->name('productos.index');
Route::get('/productos/{id}', [TiendaController::class, 'mostrarProducto'])->name('productos.show');

// Carrito (algunos públicos y otros protegidos)
Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito');
Route::post('/carrito/agregar/{id}', [CarritoController::class, 'agregar'])->name('carrito.agregar');
Route::post('/carrito/eliminar/{id}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');
Route::get('/carrito/dropdown-content', [CarritoController::class, 'dropdownContent'])->name('carrito.dropdown');

// Compra
Route::post('/carrito/comprar', [CarritoController::class, 'comprar'])->name('carrito.comprar');

// PayPal
Route::get('/paypal/cancel', [CompraController::class, 'cancel'])->name('paypal.cancel');
Route::get('/paypal/pay', [PayPalController::class, 'payWithPayPal'])->name('paypal.pay');
Route::get('/paypal/success', [PayPalController::class, 'success'])->name('paypal.success');

// Orden
Route::post('/orden/contraentrega', [OrdenController::class, 'storeContraentrega'])->name('orden.contraentrega');

// Otros
Route::post('/contacto', [ContactoController::class, 'enviar'])->name('contacto.enviar');
Route::get('/login-tienda', [TiendaController::class, 'login'])->name('tienda.login');

// Rutas protegidas (requieren login y verificación de email)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Ajustes de usuario (Volt)
    Route::redirect('settings', 'settings/profile');
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

    // Grupo de rutas para administrador
    Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
        Route::get('/registro_usuario', [RegistroUsuarioController::class, 'index'])->name('registro_usuario.index');
        Route::get('/registro_usuario/create', [RegistroUsuarioController::class, 'create'])->name('registro_usuario.create');
        Route::post('/registro_usuario', [RegistroUsuarioController::class, 'store'])->name('registro_usuario.store');
        Route::get('/registro_usuario/{usuario}/edit', [RegistroUsuarioController::class, 'edit'])->name('registro_usuario.edit');
        Route::put('/registro_usuario/{usuario}', [RegistroUsuarioController::class, 'update'])->name('registro_usuario.update');
        Route::delete('/registro_usuario/{usuario}', [RegistroUsuarioController::class, 'destroy'])->name('registro_usuario.destroy');
    });
});

// Auth routes
require __DIR__ . '/auth.php';

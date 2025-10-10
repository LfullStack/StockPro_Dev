<?php
use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\TipoArticuloController;
use App\Http\Controllers\Admin\ProveedorController;
use App\Http\Controllers\Admin\ProductoController;
use App\Http\Controllers\Admin\EmpresaController;
use App\Http\Controllers\Admin\FacturaProveedorController;
use App\Http\Controllers\Admin\InventarioController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UnidadMedidaController;
use App\Http\Controllers\Admin\FacturaClienteController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ReporteFacturaClienteController;
use App\Http\Controllers\Admin\ReporteFacturaProveedorController;
use App\Http\Controllers\Admin\MetaVentaController;
use App\Http\Controllers\VentaRapidaController;
use App\Livewire\Admin\EventosIndex;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;


// Rutas para administrador y auxiliar
Route::resource('categorias',CategoriaController::class);
Route::resource('tipos_articulos',TipoArticuloController::class)->parameters([
    'tipos_articulos' => 'tipoArticulo']);
Route::resource('proveedores',ProveedorController::class)->parameters([
    'proveedores' => 'proveedor']);
Route::resource('productos',ProductoController::class);
Route::resource('empresas',EmpresaController::class);
Route::resource('facturas_proveedores',FacturaProveedorController::class);
Route::resource('inventarios',InventarioController::class);
Route::resource('users',USerController::class);
Route::resource('unidades_medidas',UnidadMedidaController::class)->parameters(['unidades_medidas' => 'unidadMedida']);
Route::resource('facturas_clientes',FacturaClienteController::class);
Route::resource('posts',PostController::class);



Route::get('reportes/facturas_clientes', [ReporteFacturaClienteController::class, 'index'])->name('reportes.facturas_clientes.index');

Route::get('reportes/facturas_clientes/exportar', [ReporteFacturaClienteController::class, 'exportarExcel'])
    ->name('reportes.facturas_clientes.exportar');

Route::get('reportes/facturas_proveedores', [ReporteFacturaProveedorController::class, 'index'])->name('reportes.facturas_proveedores.index');

Route::get('reportes/facturas_proveedores/exportar', [ReporteFacturaProveedorController::class, 'exportarExcel'])
    ->name('reportes.facturas_proveedores.exportar');

Route::resource('metas_ventas', MetaVentaController::class)->names('metas_ventas');

Route::get('eventos', EventosIndex::class)->name('eventos.index');

// Ruta para ventab rapida
Route::get('venta_rapida', [VentaRapidaController::class, 'index'])->name('venta_rapida.index');



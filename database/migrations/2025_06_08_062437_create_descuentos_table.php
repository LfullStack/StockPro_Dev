<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('descuentos', function (Blueprint $table) {
            $table->id();

            // Definición del tipo de descuento (producto, proveedor, categoría, global)
            $table->enum('tipo', ['producto', 'categoria', 'proveedor','tipo_articulo', 'global']);

            // FK opcionales, solo uno se usará según el tipo
            $table->unsignedBigInteger('producto_id')->nullable();
            $table->unsignedBigInteger('categoria_id')->nullable();
            $table->unsignedBigInteger('proveedor_id')->nullable();
            $table->unsignedBigInteger('tipo_articulo_id')->nullable();

            // Porcentaje de descuento (ej: 15 = 15%)
            $table->decimal('porcentaje', 5, 2)->default(0);

            // Rango de fechas válido para el descuento
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();

            $table->timestamps();

            // Restricciones condicionales
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('cascade');
            $table->foreign('proveedor_id')->references('id')->on('proveedores')->onDelete('cascade');
            $table->foreign('tipo_articulo_id')->references('id')->on('tipo_articulos')->onDelete('cascade');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('descuentos');
    }
};

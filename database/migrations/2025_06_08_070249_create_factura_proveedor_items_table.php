<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('factura_proveedor_items', function (Blueprint $table) {

            $table->id();
            $table->foreignId('producto_id')->constrained('productos')->onDelete('restrict');
            $table->string('unidad_medida', 20); 
            $table->decimal('cantidad',10,2);
            $table->decimal('precio_unitario', 15, 2);
            $table->decimal('descuento', 15, 2)->default(0);
            $table->decimal('impuesto', 12, 2);
            $table->decimal('subtotal', 20, 2);

            
            $table->foreignId('factura_id')->constrained('facturas_proveedores')->onDelete('cascade');
            $table->timestamps();
            
    });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factura_proveedor_items');

    }
};

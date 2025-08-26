<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('factura_cliente_items', function (Blueprint $table) {
            $table->id();

            // Usar foreignId con constrained para FK
            $table->foreignId('factura_cliente_id')
                ->constrained('facturas_clientes')
                ->onDelete('cascade');

            $table->foreignId('producto_id')
                ->constrained('productos')
                ->onDelete('restrict');

            $table->integer('cantidad');
            $table->string('unidad_medida', 20);
            $table->decimal('precio_unitario', 15, 2);
            $table->decimal('impuesto', 10, 2)->default(0);
            $table->decimal('descuento', 15, 2)->default(0);
            $table->decimal('subtotal', 15, 2);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('factura_cliente_items');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('inventarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre'); // Nombre interno o referencia
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            $table->string('unidad_medida', 20);
            $table->integer('cantidad')->default(0);
            $table->decimal('precio', 15, 2);
            $table->unsignedTinyInteger('descuento')->default(0);
            $table->foreignId('empresa_id')->constrained('empresas')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventarios');
    }
};

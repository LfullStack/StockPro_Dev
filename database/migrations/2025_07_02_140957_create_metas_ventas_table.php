<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('metas_ventas', function (Blueprint $table) {
        $table->id();
        $table->decimal('monto_meta', 15, 2); // Ej: 500000.00
        $table->enum('tipo', ['mensual', 'semanal'])->default('mensual');
        $table->unsignedInteger('anio');
        $table->unsignedTinyInteger('mes')->nullable(); // 1-12 para mensual
        $table->unsignedTinyInteger('semana')->nullable(); // 1-52 para semanal
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('metas_ventas');
    }
};

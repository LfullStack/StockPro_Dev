<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Usuario que ejecutó el evento

            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->string('tipo')->default('info'); // info, warning, success, error

            $table->string('modelo')->nullable(); // Ej: 'FacturaProveedor'
            $table->unsignedBigInteger('modelo_id')->nullable(); // ID del modelo relacionado
            $table->boolean('visto')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};

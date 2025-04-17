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
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->id();
            $table->boolean('activo')->default(true);
            $table->string('tipo' );
            $table->foreignId('relacion_marca_modelo_id')->constrained('relacion_marca_modelo')->onDelete('cascade')->onUpdate('cascade');
            $table->string('color', 255);
            $table->string('placa', 12)->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehiculos');
    }
};

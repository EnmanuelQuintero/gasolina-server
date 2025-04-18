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
        Schema::create('relacion_orden_detalle', function (Blueprint $table) {
            $table->id();
            $table->boolean('activo')->default(true);
            $table->boolean('entregado')->default(false); // Nuevo campo booleano
            $table->date('fecha_entrega')->nullable(); // Nuevo campo fecha, puede ser nulo
            $table->foreignId('orden_id')->constrained('orden')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('detalle_orden_id')->constrained('detalle_orden')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relacion_orden_detalle');
    }
};

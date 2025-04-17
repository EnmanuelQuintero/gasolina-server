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
        Schema::create('detalle_orden', function (Blueprint $table) {
            $table->id();
            $table->boolean('activo')->default(true); 
            $table->foreignId('vehiculo_id')->constrained('vehiculos')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('chofer_id')->constrained('personas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('combustible_id')->constrained('combustibles')->onDelete('cascade')->onUpdate('cascade');
            $table->decimal('cantidad', 8, 2);
            $table->string('medida');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_orden');
    }
};

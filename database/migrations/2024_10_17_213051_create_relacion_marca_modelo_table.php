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
        Schema::create('relacion_marca_modelo', function (Blueprint $table) {
            $table->id();
            $table->boolean('activo')->default(true);
            $table->foreignId('marca_id')->constrained('marcas')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('modelo_id')->constrained('modelos')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relacion_marca_modelo');
    }
};

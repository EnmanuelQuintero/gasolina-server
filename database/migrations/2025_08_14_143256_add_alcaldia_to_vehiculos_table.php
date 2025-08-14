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
        Schema::table('vehiculos', function (Blueprint $table) {
            // Agregar el campo 'alcaldia' como booleano
            $table->boolean('alcaldia')->default(false); // Se agrega como un booleano con valor predeterminado false (0)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehiculos', function (Blueprint $table) {
            // Eliminar el campo 'alcaldia' si se revierte la migración
            $table->dropColumn('alcaldia');
        });
    }
};

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
        Schema::create('relacion_departamento_cargo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('departamento_id')->constrained('departamentos')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('cargo_id')->constrained('cargos')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relacion_departamento_cargo');
    }
};

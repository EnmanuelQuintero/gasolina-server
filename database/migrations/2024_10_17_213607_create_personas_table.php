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
        Schema::create('personas', function (Blueprint $table) {
            $table->id();
            $table->boolean('activo')->default(true);
            $table->string('primer_nombre', 255);
            $table->string('segundo_nombre', 255)->nullable();
            $table->string('primer_apellido', 255);
            $table->string('segundo_apellido', 255)->nullable();
            $table->foreignId('departamento_cargo_id')->constrained('relacion_departamento_cargo')->onUpdate('cascade')->onDelete('cascade')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personas');
    }
};

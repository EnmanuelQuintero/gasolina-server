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
        Schema::create('orden', function (Blueprint $table) {
            $table->id();
            $table->boolean('activo')->default(true);
            $table->date('fecha');
            $table->foreignId('gasolinera_id')->constrained('gasolineras')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('autorizado_id')->constrained('personas')->onDelete('cascade')->onUpdate('cascade');
            $table->string('token', 20);
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orden');
    }
};

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
        Schema::table('detalle_orden', function (Blueprint $table) {
            // Agregar el campo 'kilometros', que puede ser NULL
            $table->decimal('kilometros', 8, 2)->nullable()->after('medida'); // Después del campo 'medida'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detalle_orden', function (Blueprint $table) {
            // Eliminar el campo 'kilometros' en caso de revertir la migración
            $table->dropColumn('kilometros');
        });
    }
};

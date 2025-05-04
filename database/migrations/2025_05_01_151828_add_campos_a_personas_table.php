<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('personas', function (Blueprint $table) {
            $table->string('cedula', 20)->nullable()->after('departamento_cargo_id');
            $table->boolean('autorizado')->default(false)->after('cedula');
            $table->boolean('chofer')->default(false)->after('autorizado');
        });
    }

    public function down(): void
    {
        Schema::table('personas', function (Blueprint $table) {
            $table->dropColumn(['cedula', 'autorizado', 'chofer']);
        });
    }
};

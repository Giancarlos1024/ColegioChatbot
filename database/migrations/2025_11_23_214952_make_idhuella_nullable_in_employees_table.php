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
        Schema::table('employees', function (Blueprint $table) {
            // 1. Quitar el índice UNIQUE existente
            $table->dropUnique(['idHuella']);

            // 2. Ahora sí volver nullable
            $table->integer('idHuella')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            // revertir cambios
            $table->integer('idHuella')->nullable(false)->change();
            $table->unique('idHuella');
        });
    }


};

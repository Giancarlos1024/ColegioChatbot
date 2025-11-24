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
        Schema::table('alerts', function (Blueprint $table) {
            // 👇 Agregamos el título
            $table->string('titulo')
                ->after('idMovimientos')
                ->nullable();

            // 👇 Si ya no vas a usar movements, eliminamos la columna JSON
            $table->dropColumn('idMovimientos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alerts', function (Blueprint $table) {
            // Volvemos a crear la columna idMovimientos (por si haces rollback)
            $table->json('idMovimientos')->nullable();

            // Quitamos el título
            $table->dropColumn('titulo');
        });
    }
};

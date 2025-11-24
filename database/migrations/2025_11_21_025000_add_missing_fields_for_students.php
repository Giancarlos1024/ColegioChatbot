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
        // 1. Agregar campo role a la tabla users
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('estudiante')->after('password');
        });

        // 2. Crear tabla inscripciones para relación users-talleres
        Schema::create('inscripciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('taller_id')->constrained('taller')->onDelete('cascade');
            $table->dateTime('fecha_inscripcion');
            $table->enum('estado', ['activa', 'inactiva', 'cancelada'])->default('activa');
            $table->text('notas')->nullable();
            $table->timestamps();
            
            // Asegurar que un usuario no pueda inscribirse dos veces al mismo taller
            $table->unique(['user_id', 'taller_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscripciones');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};

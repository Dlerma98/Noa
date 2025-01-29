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
        Schema::create('analyses', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Título del análisis
            $table->text('content'); // Contenido del análisis
            $table->unsignedTinyInteger('score'); // Puntuación (1 a 10)
            $table->string('genre'); // Género del videojuego (acción, aventura, etc.)
            $table->enum('console', ['PlayStation', 'Xbox', 'PC', 'Switch'])->nullable(); // Consola (opcional)
            $table->enum('type', ['Review', 'Retro', 'News'])->default('Review'); // Tipo de análisis
            $table->timestamps(); // created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analyses');
    }
};

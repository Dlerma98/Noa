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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('title'); // Título del post
            $table->string('thumbnail')->nullable(); // URL de la miniatura
            $table->text('excerpt'); // Resumen del contenido
            $table->text('content'); // Contenido completo
            $table->enum('category', ['PlayStation', 'Xbox', 'PC', 'Switch']); // Consola o categoría
            $table->enum('type', ['Exclusive', 'Multiplatform']); // Tipo de post
            $table->timestamps(); // created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};

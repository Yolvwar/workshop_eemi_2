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
    Schema::create('pet_photos', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->foreignUuid('pet_id')->constrained()->onDelete('cascade');

      // Détails de la photo
      $table->string('filename');
      $table->string('original_name')->nullable();
      $table->string('url', 500);
      $table->string('thumbnail_url', 500)->nullable();

      // Métadonnées
      $table->integer('file_size')->nullable();
      $table->string('mime_type', 50)->nullable();
      $table->integer('width')->nullable();
      $table->integer('height')->nullable();

      // Catégorisation
      $table->string('category', 50)->nullable();
      $table->text('tags')->nullable();
      $table->text('description')->nullable();

      // IA Analysis
      $table->json('ai_analysis')->nullable();

      // Dates
      $table->timestamp('taken_at')->nullable();
      $table->timestamp('uploaded_at')->default(now());

      // Visibilité
      $table->boolean('is_public')->default(false);
      $table->boolean('is_profile_picture')->default(false);

      $table->timestamps();

      // Index
      $table->index(['pet_id']);
      $table->index(['category']);
      $table->index(['taken_at']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('pet_photos');
  }
};

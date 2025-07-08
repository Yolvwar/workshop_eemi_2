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
    Schema::create('product_reviews', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->foreignUuid('product_id')->constrained()->onDelete('cascade');
      $table->foreignUuid('user_id')->constrained()->onDelete('cascade');
      $table->foreignUuid('pet_id')->nullable()->constrained()->onDelete('set null');

      // Évaluation
      $table->integer('rating')->check('rating >= 1 AND rating <= 5');
      $table->string('title', 200)->nullable();
      $table->text('review')->nullable();

      // Détails d'utilisation
      $table->string('usage_duration', 50)->nullable();
      $table->string('purchased_for', 50)->nullable();

      // Piliers APWAP évalués
      $table->json('pillar_ratings')->nullable();

      // Médias
      $table->json('photos')->nullable();
      $table->json('videos')->nullable();

      // Statut
      $table->boolean('is_verified_purchase')->default(false);
      $table->boolean('is_approved')->default(false);
      $table->boolean('is_featured')->default(false);

      // Utilité
      $table->integer('helpful_votes')->default(0);
      $table->integer('total_votes')->default(0);

      $table->timestamps();

      // Index
      $table->index(['product_id']);
      $table->index(['user_id']);
      $table->index(['rating']);
      $table->index(['is_approved']);

      // Contrainte unique
      $table->unique(['product_id', 'user_id']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('product_reviews');
  }
};

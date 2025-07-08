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
    Schema::create('product_categories', function (Blueprint $table) {
      $table->uuid('id')->primary();

      // Hiérarchie
      $table->uuid('parent_id')->nullable();
      $table->string('name', 100);
      $table->string('slug', 100)->unique();
      $table->text('description')->nullable();

      // Métadonnées
      $table->string('icon', 100)->nullable();
      $table->string('image_url', 500)->nullable();
      $table->string('banner_url', 500)->nullable();

      // SEO
      $table->string('meta_title', 200)->nullable();
      $table->text('meta_description')->nullable();
      $table->text('meta_keywords')->nullable();

      // Ordering
      $table->integer('sort_order')->default(0);
      $table->boolean('is_active')->default(true);

      // Piliers APWAP
      $table->text('related_pillars')->nullable();

      $table->timestamps();

      // Index
      $table->index(['parent_id']);
      $table->index(['slug']);
      $table->index(['related_pillars']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('product_categories');
  }
};

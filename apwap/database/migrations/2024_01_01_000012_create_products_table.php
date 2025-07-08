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
    Schema::create('products', function (Blueprint $table) {
      $table->uuid('id')->primary();

      // Informations de base
      $table->string('name');
      $table->string('slug')->unique();
      $table->text('description')->nullable();
      $table->text('short_description')->nullable();
      $table->string('sku', 100)->unique();
      $table->string('barcode', 100)->nullable();

      // Catégorisation
      $table->foreignUuid('category_id')->constrained('product_categories')->onDelete('cascade');
      $table->string('brand', 100)->nullable();
      $table->text('tags')->nullable();

      // Spécifications animaux
      $table->text('suitable_for_species')->nullable();
      $table->text('suitable_for_ages')->nullable();
      $table->text('suitable_for_sizes')->nullable();

      // Piliers APWAP
      $table->string('primary_pillar', 50)->nullable();
      $table->text('pillar_benefits')->nullable();

      // Tarification
      $table->decimal('price', 10, 2);
      $table->decimal('original_price', 10, 2)->nullable();
      $table->decimal('cost_price', 10, 2)->nullable();

      // Inventaire
      $table->integer('stock_quantity')->default(0);
      $table->integer('low_stock_threshold')->default(10);
      $table->boolean('manage_stock')->default(true);

      // Caractéristiques physiques
      $table->decimal('weight', 8, 2)->nullable();
      $table->string('dimensions', 100)->nullable();

      // Statut
      $table->string('status', 50)->default('active');
      $table->boolean('featured')->default(false);

      // Médias
      $table->json('images')->nullable();
      $table->json('videos')->nullable();

      // SEO
      $table->string('meta_title', 200)->nullable();
      $table->text('meta_description')->nullable();
      $table->text('meta_keywords')->nullable();

      // Livraison
      $table->boolean('shipping_required')->default(true);
      $table->decimal('shipping_weight', 8, 2)->nullable();
      $table->string('shipping_dimensions', 100)->nullable();

      // Évaluations
      $table->decimal('rating', 3, 2)->default(0);
      $table->integer('review_count')->default(0);

      $table->timestamps();

      // Index
      $table->index(['category_id']);
      $table->index(['slug']);
      $table->index(['sku']);
      $table->index(['price']);
      $table->index(['suitable_for_species']);
      $table->index(['primary_pillar']);
      $table->index(['status']);
      $table->index(['rating']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('products');
  }
};

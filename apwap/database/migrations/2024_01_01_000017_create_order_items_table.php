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
    Schema::create('order_items', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->foreignUuid('order_id')->constrained()->onDelete('cascade');
      $table->foreignUuid('product_id')->constrained()->onDelete('cascade');

      // Détails du produit au moment de la commande
      $table->string('product_name');
      $table->string('product_sku', 100);

      // Quantité et prix
      $table->integer('quantity');
      $table->decimal('unit_price', 10, 2);
      $table->decimal('total_price', 10, 2);

      // Personnalisation
      $table->foreignUuid('pet_id')->nullable()->constrained()->onDelete('set null');
      $table->json('customization')->nullable();

      // Statut de l'item
      $table->string('status', 50)->default('pending');

      $table->timestamps();

      // Index
      $table->index(['order_id']);
      $table->index(['product_id']);
      $table->index(['pet_id']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('order_items');
  }
};

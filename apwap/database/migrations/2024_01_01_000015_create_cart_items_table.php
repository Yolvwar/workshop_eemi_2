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
    Schema::create('cart_items', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->foreignUuid('cart_id')->constrained()->onDelete('cascade');
      $table->foreignUuid('product_id')->constrained()->onDelete('cascade');

      // Quantité et prix
      $table->integer('quantity')->default(1);
      $table->decimal('unit_price', 10, 2);
      $table->decimal('total_price', 10, 2);

      // Personnalisation
      $table->foreignUuid('pet_id')->nullable()->constrained()->onDelete('set null');
      $table->json('customization')->nullable();

      // Dates
      $table->timestamp('added_at')->default(now());
      $table->timestamps();

      // Index
      $table->index(['cart_id']);
      $table->index(['product_id']);
      $table->index(['pet_id']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('cart_items');
  }
};

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
    Schema::create('carts', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->foreignUuid('user_id')->constrained()->onDelete('cascade');

      // Statut
      $table->string('status', 50)->default('active');

      // Totaux
      $table->integer('items_count')->default(0);
      $table->decimal('subtotal', 10, 2)->default(0);
      $table->decimal('tax_amount', 10, 2)->default(0);
      $table->decimal('shipping_amount', 10, 2)->default(0);
      $table->decimal('discount_amount', 10, 2)->default(0);
      $table->decimal('total_amount', 10, 2)->default(0);

      // Coupons
      $table->string('coupon_code', 50)->nullable();

      // Dates
      $table->timestamp('abandoned_at')->nullable();
      $table->timestamp('converted_at')->nullable();
      $table->timestamps();

      // Index
      $table->index(['user_id']);
      $table->index(['status']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('carts');
  }
};

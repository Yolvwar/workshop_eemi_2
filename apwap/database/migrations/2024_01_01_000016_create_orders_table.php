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
    Schema::create('orders', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->foreignUuid('user_id')->constrained()->onDelete('cascade');

      // Numéro de commande
      $table->string('order_number', 50)->unique();

      // Statut
      $table->string('status', 50)->default('pending');
      $table->string('payment_status', 50)->default('pending');

      // Montants
      $table->decimal('subtotal', 10, 2);
      $table->decimal('tax_amount', 10, 2)->default(0);
      $table->decimal('shipping_amount', 10, 2)->default(0);
      $table->decimal('discount_amount', 10, 2)->default(0);
      $table->decimal('total_amount', 10, 2);

      // Adresse de livraison
      $table->string('shipping_first_name', 100)->nullable();
      $table->string('shipping_last_name', 100)->nullable();
      $table->string('shipping_address_line_1')->nullable();
      $table->string('shipping_address_line_2')->nullable();
      $table->string('shipping_city', 100)->nullable();
      $table->string('shipping_postal_code', 20)->nullable();
      $table->string('shipping_phone', 50)->nullable();
      $table->text('shipping_notes')->nullable();

      // Méthode de livraison
      $table->string('shipping_method', 50)->nullable();
      $table->date('estimated_delivery_date')->nullable();
      $table->date('actual_delivery_date')->nullable();

      // Paiement
      $table->string('payment_method', 50)->nullable();
      $table->string('payment_reference', 100)->nullable();

      // Coupons
      $table->string('coupon_code', 50)->nullable();

      // Dates importantes
      $table->timestamp('placed_at')->default(now());
      $table->timestamp('confirmed_at')->nullable();
      $table->timestamp('shipped_at')->nullable();
      $table->timestamp('delivered_at')->nullable();

      // Notes
      $table->text('customer_notes')->nullable();
      $table->text('admin_notes')->nullable();

      $table->timestamps();

      // Index
      $table->index(['user_id']);
      $table->index(['order_number']);
      $table->index(['status']);
      $table->index(['payment_status']);
      $table->index(['placed_at']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('orders');
  }
};

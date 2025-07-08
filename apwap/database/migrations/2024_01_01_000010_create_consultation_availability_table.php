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
    Schema::create('consultation_availability', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->foreignUuid('veterinarian_id')->constrained()->onDelete('cascade');

      // Créneaux disponibles
      $table->date('available_date');
      $table->time('start_time');
      $table->time('end_time');

      // Type de consultation disponible
      $table->text('consultation_types')->nullable();
      $table->integer('max_bookings')->default(1);
      $table->integer('current_bookings')->default(0);

      // Statut
      $table->boolean('is_available')->default(true);
      $table->boolean('is_emergency_slot')->default(false);

      // Tarification spécifique
      $table->decimal('special_rate', 8, 2)->nullable();

      $table->timestamps();

      // Index
      $table->index(['veterinarian_id']);
      $table->index(['available_date']);
      $table->index(['start_time', 'end_time']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('consultation_availability');
  }
};

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
    Schema::create('pet_vaccinations', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->foreignUuid('pet_id')->constrained()->onDelete('cascade');

      // Détails vaccination
      $table->string('vaccine_name', 100);
      $table->string('vaccine_type', 50)->nullable();
      $table->string('batch_number', 50)->nullable();
      $table->string('manufacturer', 100)->nullable();

      // Dates
      $table->date('administered_date');
      $table->date('expiry_date')->nullable();
      $table->date('next_due_date')->nullable();

      // Lieu et professionnel
      $table->string('clinic_name', 100)->nullable();
      $table->string('veterinarian_name', 100)->nullable();
      $table->string('veterinarian_license', 50)->nullable();

      // Effets et notes
      $table->text('side_effects')->nullable();
      $table->text('notes')->nullable();

      // Documents
      $table->string('certificate_url', 500)->nullable();

      $table->timestamps();

      // Index
      $table->index(['pet_id']);
      $table->index(['next_due_date']);
      $table->index(['vaccine_type']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('pet_vaccinations');
  }
};

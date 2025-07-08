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
    Schema::create('pet_medical_history', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->foreignUuid('pet_id')->constrained()->onDelete('cascade');
      $table->uuid('consultation_id')->nullable();

      // Type d'entrée
      $table->string('entry_type', 50);
      $table->string('title', 200);
      $table->text('description')->nullable();

      // Détails médicaux
      $table->text('diagnosis')->nullable();
      $table->text('treatment')->nullable();
      $table->text('prescription')->nullable();
      $table->text('recommendations')->nullable();

      // Coûts
      $table->decimal('cost', 10, 2)->nullable();
      $table->decimal('insurance_covered', 10, 2)->nullable();

      // Dates
      $table->date('date_occurred');
      $table->date('follow_up_date')->nullable();

      // Professionnel
      $table->string('veterinarian_name', 100)->nullable();
      $table->string('clinic_name', 100)->nullable();

      // Documents
      $table->json('documents')->nullable();

      $table->timestamps();

      // Index
      $table->index(['pet_id']);
      $table->index(['entry_type']);
      $table->index(['date_occurred']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('pet_medical_history');
  }
};

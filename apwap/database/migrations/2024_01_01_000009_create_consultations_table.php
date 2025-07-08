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
    Schema::create('consultations', function (Blueprint $table) {
      $table->uuid('id')->primary();

      // Participants
      $table->foreignUuid('user_id')->constrained()->onDelete('cascade');
      $table->foreignUuid('pet_id')->constrained()->onDelete('cascade');
      $table->foreignUuid('veterinarian_id')->constrained()->onDelete('cascade');

      // Détails de la consultation
      $table->string('type', 50);
      $table->string('mode', 50);
      $table->string('status', 50)->default('scheduled');

      // Planification
      $table->date('scheduled_date');
      $table->time('scheduled_time');
      $table->integer('duration_minutes')->default(45);

      // Localisation (pour visites à domicile)
      $table->string('location_type', 50)->nullable();
      $table->text('address')->nullable();
      $table->decimal('latitude', 10, 8)->nullable();
      $table->decimal('longitude', 11, 8)->nullable();

      // Consultation details
      $table->text('chief_complaint')->nullable();
      $table->text('symptoms')->nullable();
      $table->text('examination_findings')->nullable();
      $table->text('diagnosis')->nullable();
      $table->text('treatment_plan')->nullable();
      $table->text('prescriptions')->nullable();
      $table->text('recommendations')->nullable();
      $table->text('follow_up_instructions')->nullable();

      // Coûts
      $table->decimal('consultation_fee', 8, 2)->nullable();
      $table->decimal('additional_fees', 8, 2)->default(0);
      $table->decimal('total_cost', 8, 2)->nullable();
      $table->string('payment_status', 50)->default('pending');

      // Timing
      $table->timestamp('started_at')->nullable();
      $table->timestamp('completed_at')->nullable();

      // Urgence
      $table->string('priority', 20)->default('normal');
      $table->text('urgency_notes')->nullable();

      // Documents
      $table->json('documents')->nullable();

      // Évaluation
      $table->integer('user_rating')->nullable()->check('user_rating >= 1 AND user_rating <= 5');
      $table->text('user_review')->nullable();
      $table->text('vet_notes')->nullable();

      $table->timestamps();

      // Index
      $table->index(['user_id']);
      $table->index(['pet_id']);
      $table->index(['veterinarian_id']);
      $table->index(['scheduled_date']);
      $table->index(['status']);
      $table->index(['priority']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('consultations');
  }
};

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
    Schema::create('veterinarians', function (Blueprint $table) {
      $table->uuid('id')->primary();

      // Informations personnelles
      $table->string('first_name', 100);
      $table->string('last_name', 100);
      $table->string('email')->unique();
      $table->string('phone', 50)->nullable();
      $table->string('avatar_url', 500)->nullable();

      // Qualifications
      $table->string('license_number', 50)->unique();
      $table->text('specializations')->nullable();
      $table->text('languages')->nullable();
      $table->integer('experience_years')->nullable();

      // Localisation
      $table->string('clinic_name', 100)->nullable();
      $table->text('clinic_address')->nullable();
      $table->string('clinic_phone', 50)->nullable();
      $table->text('service_areas')->nullable();

      // Disponibilité
      $table->json('working_hours')->nullable();
      $table->string('availability_status', 20)->default('available');

      // Tarification
      $table->decimal('consultation_fee', 8, 2)->nullable();
      $table->decimal('home_visit_fee', 8, 2)->nullable();
      $table->decimal('teleconsultation_fee', 8, 2)->nullable();
      $table->decimal('emergency_fee', 8, 2)->nullable();

      // Évaluations
      $table->decimal('rating', 3, 2)->default(0);
      $table->integer('total_reviews')->default(0);
      $table->integer('total_consultations')->default(0);

      // Statut
      $table->boolean('is_active')->default(true);
      $table->boolean('is_verified')->default(false);
      $table->timestamp('verification_date')->nullable();

      $table->timestamps();

      // Index
      $table->index(['license_number']);
      $table->index(['specializations']);
      $table->index(['rating']);
      $table->index(['availability_status']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('veterinarians');
  }
};

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
    Schema::create('pet_health_records', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->foreignUuid('pet_id')->constrained()->onDelete('cascade');

      // Informations médicales
      $table->string('blood_type', 20)->nullable();
      $table->text('allergies')->nullable();
      $table->text('chronic_conditions')->nullable();
      $table->text('current_medications')->nullable();
      $table->text('dietary_restrictions')->nullable();

      // Assurance
      $table->string('insurance_provider', 100)->nullable();
      $table->string('insurance_policy_number', 100)->nullable();
      $table->date('insurance_expires_at')->nullable();

      // Vétérinaire principal
      $table->string('primary_vet_name', 100)->nullable();
      $table->string('primary_vet_clinic', 100)->nullable();
      $table->string('primary_vet_phone', 50)->nullable();
      $table->string('primary_vet_email', 100)->nullable();

      // Contacts d'urgence
      $table->string('emergency_contact_name', 100)->nullable();
      $table->string('emergency_contact_phone', 50)->nullable();
      $table->string('emergency_contact_relation', 50)->nullable();

      $table->timestamps();

      // Index
      $table->index(['pet_id']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('pet_health_records');
  }
};

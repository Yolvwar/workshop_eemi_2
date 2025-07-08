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
    // Ajout de la contrainte de foreign key pour consultation_id dans pet_medical_history
    Schema::table('pet_medical_history', function (Blueprint $table) {
      $table->foreign('consultation_id')->references('id')->on('consultations')->onDelete('set null');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('pet_medical_history', function (Blueprint $table) {
      $table->dropForeign(['consultation_id']);
    });
  }
};

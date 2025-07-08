<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    // Ajout des contraintes de vérification pour les scores des animaux
    DB::statement('ALTER TABLE pets ADD CONSTRAINT check_health_score CHECK (health_score >= 0 AND health_score <= 100)');
    DB::statement('ALTER TABLE pets ADD CONSTRAINT check_education_score CHECK (education_score >= 0 AND education_score <= 100)');
    DB::statement('ALTER TABLE pets ADD CONSTRAINT check_nutrition_score CHECK (nutrition_score >= 0 AND nutrition_score <= 100)');
    DB::statement('ALTER TABLE pets ADD CONSTRAINT check_activity_score CHECK (activity_score >= 0 AND activity_score <= 100)');
    DB::statement('ALTER TABLE pets ADD CONSTRAINT check_lifestyle_score CHECK (lifestyle_score >= 0 AND lifestyle_score <= 100)');
    DB::statement('ALTER TABLE pets ADD CONSTRAINT check_emotional_score CHECK (emotional_score >= 0 AND emotional_score <= 100)');
    DB::statement('ALTER TABLE pets ADD CONSTRAINT check_overall_score CHECK (overall_score >= 0 AND overall_score <= 100)');

    // Ajout des contraintes de vérification pour les prix des produits
    DB::statement('ALTER TABLE products ADD CONSTRAINT check_positive_price CHECK (price > 0)');
    DB::statement('ALTER TABLE products ADD CONSTRAINT check_positive_original_price CHECK (original_price IS NULL OR original_price > 0)');

    // Ajout des contraintes de vérification pour les dates de consultations
    DB::statement('ALTER TABLE consultations ADD CONSTRAINT check_future_consultation_date CHECK (scheduled_date >= CURRENT_DATE)');
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    // Suppression des contraintes de vérification pour les scores des animaux
    DB::statement('ALTER TABLE pets DROP CONSTRAINT IF EXISTS check_health_score');
    DB::statement('ALTER TABLE pets DROP CONSTRAINT IF EXISTS check_education_score');
    DB::statement('ALTER TABLE pets DROP CONSTRAINT IF EXISTS check_nutrition_score');
    DB::statement('ALTER TABLE pets DROP CONSTRAINT IF EXISTS check_activity_score');
    DB::statement('ALTER TABLE pets DROP CONSTRAINT IF EXISTS check_lifestyle_score');
    DB::statement('ALTER TABLE pets DROP CONSTRAINT IF EXISTS check_emotional_score');
    DB::statement('ALTER TABLE pets DROP CONSTRAINT IF EXISTS check_overall_score');

    // Suppression des contraintes de vérification pour les prix des produits
    DB::statement('ALTER TABLE products DROP CONSTRAINT IF EXISTS check_positive_price');
    DB::statement('ALTER TABLE products DROP CONSTRAINT IF EXISTS check_positive_original_price');

    // Suppression des contraintes de vérification pour les dates de consultations
    DB::statement('ALTER TABLE consultations DROP CONSTRAINT IF EXISTS check_future_consultation_date');
  }
};

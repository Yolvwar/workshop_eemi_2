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
    Schema::create('pets', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->foreignUuid('user_id')->constrained()->onDelete('cascade');

      // Informations de base
      $table->string('name', 100);
      $table->string('species', 50);
      $table->string('breed', 100)->nullable();
      $table->string('gender', 10)->nullable();
      $table->boolean('is_neutered')->default(false);

      // Dates importantes
      $table->date('birth_date')->nullable();
      $table->date('adoption_date')->nullable();
      $table->date('registration_date')->default(now());

      // Caractéristiques physiques
      $table->decimal('weight', 5, 2)->nullable();
      $table->decimal('height', 5, 2)->nullable();
      $table->string('color', 100)->nullable();
      $table->text('markings')->nullable();

      // Identification
      $table->string('microchip_number', 50)->nullable();
      $table->string('registration_number', 50)->nullable();
      $table->string('passport_number', 50)->nullable();

      // Profil comportemental
      $table->integer('energy_level')->nullable()->check('energy_level >= 1 AND energy_level <= 10');
      $table->string('sociability', 50)->nullable();
      $table->integer('obedience_level')->nullable()->check('obedience_level >= 1 AND obedience_level <= 10');

      // Préférences et habitudes
      $table->text('favorite_toys')->nullable();
      $table->text('feeding_schedule')->nullable();
      $table->text('exercise_routine')->nullable();
      $table->text('sleeping_habits')->nullable();
      $table->text('fears_phobias')->nullable();

      // Scores des 6 piliers (0-100)
      $table->integer('health_score')->default(0);
      $table->integer('education_score')->default(0);
      $table->integer('nutrition_score')->default(0);
      $table->integer('activity_score')->default(0);
      $table->integer('lifestyle_score')->default(0);
      $table->integer('emotional_score')->default(0);
      $table->integer('overall_score')->default(0);

      // Méta-données
      $table->string('profile_image_url', 500)->nullable();
      $table->boolean('is_active')->default(true);
      $table->timestamps();

      // Index
      $table->index(['user_id']);
      $table->index(['species']);
      $table->index(['overall_score']);
      $table->index(['microchip_number']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('pets');
  }
};

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
    Schema::create('notifications', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->foreignUuid('user_id')->constrained()->onDelete('cascade');

      // Contenu
      $table->string('type', 50);
      $table->string('title', 200);
      $table->text('message');

      // Données contextuelles
      $table->json('data')->nullable();

      // Action
      $table->string('action_url', 500)->nullable();
      $table->string('action_text', 100)->nullable();

      // Priorité
      $table->string('priority', 20)->default('normal');

      // Canaux
      $table->boolean('sent_push')->default(false);
      $table->boolean('sent_email')->default(false);
      $table->boolean('sent_sms')->default(false);

      // Timing
      $table->timestamp('scheduled_at')->nullable();
      $table->timestamp('sent_at')->nullable();
      $table->timestamp('read_at')->nullable();

      // Statut
      $table->boolean('is_read')->default(false);
      $table->boolean('is_archived')->default(false);

      $table->timestamps();

      // Index
      $table->index(['user_id']);
      $table->index(['type']);
      $table->index(['priority']);
      $table->index(['is_read']);
      $table->index(['scheduled_at']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('notifications');
  }
};

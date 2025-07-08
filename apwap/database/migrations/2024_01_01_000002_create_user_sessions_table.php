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
    Schema::create('user_sessions', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->foreignUuid('user_id')->constrained()->onDelete('cascade');
      $table->string('session_token');
      $table->string('device_type', 50)->nullable();
      $table->text('device_info')->nullable();
      $table->string('ip_address', 45)->nullable();
      $table->text('user_agent')->nullable();
      $table->timestamp('expires_at');
      $table->boolean('is_active')->default(true);
      $table->timestamps();

      // Index
      $table->index(['session_token']);
      $table->index(['user_id']);
      $table->index(['expires_at']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('user_sessions');
  }
};

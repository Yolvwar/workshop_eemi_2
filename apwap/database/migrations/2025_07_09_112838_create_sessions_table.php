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
        Schema::create('sessions', function (Blueprint $table) {
      $table->string('id')->primary(); // ID de session Laravel (string, pas UUID)
      $table->foreignUuid('user_id')->nullable()->constrained()->onDelete('cascade');
      $table->string('session_token');
      $table->string('device_type', 50)->nullable();
      $table->text('device_info')->nullable();
      $table->timestamp('expires_at')->nullable();
      $table->string('ip_address', 45)->nullable();
      $table->text('user_agent')->nullable();
      $table->longText('payload');
      $table->integer('last_activity');
      $table->boolean('is_active')->default(true);
      $table->timestamps();

      // Index
      $table->index(['session_token']);
      $table->index(['user_id']);
      $table->index(['last_activity']);
      $table->index(['expires_at']);
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
    }
};

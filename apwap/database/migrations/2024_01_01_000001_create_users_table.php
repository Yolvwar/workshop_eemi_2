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
    Schema::create('users', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->string('email')->unique();
      $table->timestamp('email_verified_at')->nullable();
      $table->string('password');
      $table->string('phone', 50)->nullable();
      $table->timestamp('phone_verified_at')->nullable();

      // Informations personnelles
      $table->string('first_name', 100);
      $table->string('last_name', 100);
      $table->date('date_of_birth')->nullable();
      $table->string('avatar_url', 500)->nullable();

      // Localisation
      $table->string('country', 100)->default('UAE');
      $table->string('city', 100)->default('Dubai');
      $table->string('address_line_1')->nullable();
      $table->string('address_line_2')->nullable();
      $table->string('postal_code', 20)->nullable();
      $table->decimal('latitude', 10, 8)->nullable();
      $table->decimal('longitude', 11, 8)->nullable();

      // Préférences
      $table->string('language', 10)->default('fr');
      $table->string('currency', 10)->default('AED');
      $table->string('timezone', 50)->default('Asia/Dubai');

      // Membership
      $table->string('membership_type', 50)->default('basic');
      $table->timestamp('membership_expires_at')->nullable();
      $table->decimal('total_spent', 10, 2)->default(0);
      $table->integer('loyalty_points')->default(0);

      // Paramètres
      $table->string('theme', 20)->default('auto');
      $table->boolean('notification_push')->default(true);
      $table->boolean('notification_email')->default(true);
      $table->boolean('notification_sms')->default(false);

      // Audit
      $table->timestamp('last_login_at')->nullable();
      $table->boolean('is_active')->default(true);
      $table->timestamps();

      // Index
      $table->index(['email']);
      $table->index(['phone']);
      $table->index(['latitude', 'longitude']);
      $table->index(['membership_type', 'membership_expires_at']);
    });

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
    Schema::dropIfExists('users');
  }
};

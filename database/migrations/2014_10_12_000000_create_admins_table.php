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
        Schema::create('admins', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->boolean('super_admin')->default(false);
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('mobile');
            $table->boolean('tfa')->default(false);
            $table->char('tfa_otp', 6)->nullable();
            $table->enum('theme', ['auto', 'light', 'dark'])->default('auto');
            $table->string('avatar')->nullable();
            $table->timestamp('last_seen_at')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->char('api_token', 40)->collation('utf8mb4_bin')->unique();
            $table->char('password', 60);
            $table->char('remember_token', 60)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};

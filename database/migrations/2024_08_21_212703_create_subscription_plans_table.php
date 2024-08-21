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
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->integer('max_bookings');
            $table->boolean('has_sms_notifications')->default(false);
            $table->boolean('has_email_notifications')->default(true);
            $table->decimal('price', 8, 2);
            $table->integer('duration_in_days');
            $table->enum('status', \App\Models\SubscriptionPlan::STATUSES)->default('Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_plans');
    }
};

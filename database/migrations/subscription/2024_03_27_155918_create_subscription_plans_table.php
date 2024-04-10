<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('The name of the subscription plan');
            $table->decimal('points', 8, 2)->comment('The points of the subscription plan');
            $table->decimal('points_annually', 8, 2)->comment('The points / year of the subscription plan');
            $table->string('frequency')->comment('Subscription frequency: monthly or annually');
            $table->text('description')->nullable()->comment('A brief description of the subscription plan');
            $table->decimal('rate')->default(9.99)->comment('Rate limit of total points');
            $table->boolean('is_popular')->default(0)->comment('Plan is popular');
            $table->boolean('is_active')->nullable()->comment('Is active or not');
            $table->timestamps();
            $table->softDeletes();
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

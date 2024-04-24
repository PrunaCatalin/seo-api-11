<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Tenants\App\Enums\Subscription\SubscriptionStatus;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customer_subscription_plan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id')->comment('Foreign key linking to the customers table.');
            $table->unsignedBigInteger('subscription_plan_id')->comment(
                'Foreign key linking to the subscription_plans table.'
            );
            $table->boolean('is_active')->default(true)->comment('Is active or not');
            $table->enum('status', [
                SubscriptionStatus::ACTIVE->value,
                SubscriptionStatus::PENDING->value,
                SubscriptionStatus::EXPIRED->value,
                SubscriptionStatus::CANCELED->value,
                SubscriptionStatus::CANCELED_BY_CLIENT->value
            ])->default(SubscriptionStatus::PENDING->value);
            $table->string('frequency')->default('monthly')->comment(
                'Subscription frequency: monthly or annually'
            );
            $table->timestamp('ended_at')->comment('Subscription ended');
            $table->timestamps();

            // Define foreign key constraints and add comments for clarity
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('subscription_plan_id')->references('id')->on('subscription_plans')->onDelete(
                'cascade'
            );

            // Ensure that a customer is linked to a unique subscription plan at any time
            $table->unique(['customer_id', 'subscription_plan_id'], 'customer_plan_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_subscription_plan');
    }
};

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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('The name of the payment method, e.g., Credit Card, PayPal.');
            $table->string('provider')->comment(
                'The provider of the payment method, e.g., Stripe, PayPal. This helps identify which payment service is used.'
            );
            $table->json('configurations')->nullable()->comment(
                'A JSON column to store specific configuration settings for each payment method, such as API keys, secrets, etc.'
            );
            $table->boolean('is_active')->default(true)->comment(
                'A boolean flag to indicate whether the payment method is active and should be available for use.'
            );
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};

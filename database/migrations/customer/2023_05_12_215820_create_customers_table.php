<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id')->comment('Fk -> tenant (tenant relation)');
            $table->foreign('tenant_id')->references('id')->on('tenants');
            $table->string('referral_id')->comment('customer referral ID');
            $table->string('email')->comment('customer email');
            $table->timestamp('email_verified_at')->nullable()->comment('customer date email was verified');
            $table->string('password')->comment('customer password');
            $table->boolean('is_guest')->default(false)->comment('customer is registered or not');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
};

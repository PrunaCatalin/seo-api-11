<?php
/*
 * ${PROJECT_NAME} | 2024_03_26_195708_create_customer_referral.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 26.03.2024 19:57
*/

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('customer_referral', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('referrer_id');
            $table->unsignedBigInteger('referred_id');
            $table->timestamp('referred_at')->nullable();
            $table->timestamps();

            $table->foreign('referrer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('referred_id')->references('id')->on('customers')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_referral');
    }
};

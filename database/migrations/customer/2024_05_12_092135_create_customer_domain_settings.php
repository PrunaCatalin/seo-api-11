<?php
/*
 * ${PROJECT_NAME} | 2024_05_12_092135_create_customer_domain_settings.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 12.05.2024 09:21
*/

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('customer_domain_settings', function (Blueprint $table) {
            $table->id();


            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_domain_settings');
    }
};

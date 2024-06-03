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
            $table->foreignId('customer_id')->comment('Fk customers.id');
            $table->foreignId('customer_domains_id')->comment('Fk customer_domains.id');
            $table->json('countries')->comment('Json list of allowed countries');
            $table->json('keywords')->comment('Json list of keywords to be used for each domain');
            $table->json('links')->comment('Json list of links to be used for queues');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_domain_settings');
    }
};

<?php

/*
 * ${PROJECT_NAME} | 2023_10_11_122430_create_categories_table.php
 * https://www.webdirect.ro/
 * Copyright 2023 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 12:24
*/

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id')->comment("Fk -> tenant (tenant relation)");
            $table->foreign('tenant_id')->references('id')->on('tenants');
            $table->unsignedBigInteger('parent_id')->comment(" Id from current table used for children");
            $table->integer('order_list');
            $table->string('name');
            $table->string('url_seo');
            $table->string('icon');
            $table->boolean('is_customer')->default(false);
            $table->boolean('is_active')->default(false);
            $table->boolean('age_restricted');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_categories');
    }
};

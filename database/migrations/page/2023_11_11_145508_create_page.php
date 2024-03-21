<?php

/*
 * ${PROJECT_NAME} | 2023_11_11_145508_create_page.php
 * https://www.webdirect.ro/
 * Copyright 2023 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 11/11/2023 2:55 PM
*/

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('page', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id')->comment("Fk -> tenant (tenant relation)");
            $table->foreign('tenant_id')->references('id')->on('tenants');
            $table->unsignedBigInteger('id_parent')->comment('Page parent -> internal relation');
            $table->boolean('is_homepage')->default(false)->comment('Page is homepage ? 0 -> no , 1 -> yes');
            $table->boolean('is_mobile')->default(false)->comment('Page is mobile ? 0 -> no , 1 -> yes');
            $table->boolean('is_blackfriday')->default(false)->comment('Page is blackfriday ? 0 -> no , 1 -> yes');
            $table->string('title')->comment('Page title');
            $table->string('url_seo')->comment('Page url seo');
            $table->text('description')->comment('Page description');
            $table->boolean('published')->comment('Page can be read by normal users 0 -> false , 1 -> true');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page');
    }
};

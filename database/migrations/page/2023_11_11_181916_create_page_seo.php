<?php

/*
 * ${PROJECT_NAME} | 2023_11_11_181916_create_page_seo.php
 * https://www.webdirect.ro/
 * Copyright 2023 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 11/11/2023 6:19 PM
*/

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('page_seo', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('page_id')->comment('fk -> pages.id');
            $table->string('meta_title')->comment('Page meta title')->nullable();
            $table->text('meta_description')->comment('Page meta description')->nullable();
            $table->text('meta_keywords')->comment('Page meta keywords')->nullable();
            $table->timestamps();

            $table->foreign('page_id')->references('id')->on('page');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_seo');
    }
};

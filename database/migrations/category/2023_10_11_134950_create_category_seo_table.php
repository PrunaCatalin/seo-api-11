<?php

/*
 * ${PROJECT_NAME} | 2023_10_11_134950_create_category_seo_table.php
 * https://www.webdirect.ro/
 * Copyright 2023 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 13:49
*/

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('category_seo', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('category_id')->comment("Fk -> product_categories.id");
            $table->foreign('category_id')->references('id')->on('categories');
            $table->string('meta_title')->comment("Meta title for category");
            $table->longText('meta_description')->comment("Meta description for category");
            $table->longText('meta_keywords')->comment("Meta keywords for category");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_categories_seo');
    }
};

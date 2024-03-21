<?php
/*
 * ${PROJECT_NAME} | 2023_10_11_140244_create_category_images_table.php
 * https://www.webdirect.ro/
 * Copyright 2023 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 14:02
*/

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('category_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->comment("FK -> categories.id");
            $table->foreign('category_id')->references('id')->on('categories');
            $table->string('image');
            $table->integer('order_list');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('category_images');
    }
};

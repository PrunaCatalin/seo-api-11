<?php

/*
 * ${PROJECT_NAME} | 2023_11_11_124502_slider_settings.php
 * https://www.webdirect.ro/
 * Copyright 2023 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 11/11/2023 12:45 PM
*/

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('slider_page_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('slider_page_id')->comment('Fk-> id.slider');
            $table->string('image')->comment('Slider image');
            $table->integer('image_order')->default(0)->comment('Slider image order');
            $table->text('settings')->nullable()->comment('Settings for slider json format');
            $table->timestamps();
            $table->foreign('slider_page_id')->references('id')->on('slider_page');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('slider_page_settings');
    }
};

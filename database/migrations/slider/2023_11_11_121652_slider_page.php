<?php

/*
 * ${PROJECT_NAME} | 2023_11_11_121652_slider.php
 * https://www.webdirect.ro/
 * Copyright 2023 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 11/11/2023 12:16 PM
*/

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('slider_page', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id')->comment("Fk -> tenant (tenant relation)");
            $table->foreign('tenant_id')->references('id')->on('tenants');
            $table->unsignedBigInteger('page_id')->comment('Fk-> id.pages');
            $table->string('type')->nullable()->comment('Slider type - ex: swipper , roller');
            $table->string('name')->comment('Slider name');
            $table->boolean('is_active')->default(false)->comment('Slider is active : 0 -> false, 1 -> active');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('page_id')->references('id')->on('page');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('slider_page');
    }
};

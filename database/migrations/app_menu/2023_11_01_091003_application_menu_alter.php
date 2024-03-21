<?php

/*
 * ${PROJECT_NAME} | 2023_11_01_091003_application_menu_alter.php
 * https://www.webdirect.ro/
 * Copyright 2023 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 11/1/2023 9:10 AM
*/

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('application_menu', function (Blueprint $table) {
            $table->string("location")->after('position')
                ->default(0)->comment("Location of element");
            $table->string("label")->after('name')
                ->default(0)->comment("Label name");
            //
        });
    }

    public function down(): void
    {
        Schema::table('application_menu', function (Blueprint $table) {
            $table->string("location");
            $table->string("label");
            //
        });
    }
};

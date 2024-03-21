<?php

/*
 * ${PROJECT_NAME} | 2024_03_03_124415_tenant_daily_stats.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 03.03.2024 12:44
*/

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations to create the session_data_google table.
     * This table stores individual session data collected from Google Analytics or similar services,
     * including details about the user's session such as domain, tenant, language, and more.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::connection('stats')->create('session_data_google', function (Blueprint $table) {
            $table->id()->comment('Unique identifier for each session record');
            $table->bigInteger('associated_domain_id')->comment('ID of the domain associated with the session');
            $table->string('tenant_id')->comment('Identifier for the tenant, useful in multi-tenant applications');
            $table->integer('unique_visitors')->default(0)->comment('Estimated number of unique visitors for the year');
            $table->integer('page_views')->default(0)->comment('Estimated number of unique visitors for the year');
            $table->string('title')->comment('Title of the page visited during the session');
            $table->string('language')->comment('Language of the session');
            $table->string('region')->comment('Region from where the session originated');
            $table->string('country')->comment('Country from where the session originated');
            $table->string('keyword')->comment('Search keyword that led to the session');
            $table->string('agent')->comment('User agent of the browser used for the session');
            $table->string('event')->comment('Any specific event recorded during the session');
            $table->string('architecture')->comment('Device architecture used during the session');
            $table->string('screen_resolution')->comment('Device Screen Resolution');
            $table->date('date')->comment('Date for the aggregated statistics');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations by dropping the session_data_google table.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('session_data_google');
    }
};

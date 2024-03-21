<?php

/*
 * ${PROJECT_NAME} | 2024_03_04_145630_stats_daily_google.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 04.03.2024 14:56
*/

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations to create the daily_stats table.
     * This table aggregates daily statistics from the session_data_google table,
     * summarizing key metrics such as session count, unique visitors, page views, and more.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::connection('stats')->create('daily_stats_google', function (Blueprint $table) {
            $table->id()->comment('Unique identifier for each daily stats record');
            $table->date('date')->comment('Date for the aggregated statistics');
            $table->bigInteger('associated_domain_id')->comment('Domain ID to group statistics by domain');
            $table->string('tenant_id')->comment('Tenant identifier, for multi-tenant statistics');
            $table->integer('sessions_count')->default(0)->comment('Total number of sessions for the day');
            $table->integer('unique_visitors')->default(0)->comment('Estimated number of unique visitors');
            $table->integer('page_views')->default(0)->comment('Total page views for the day');
            $table->integer('events_count')->default(0)->comment('Total number of recorded events');
            $table->string('top_keyword')->nullable()->comment('Most frequent search keyword');
            $table->string('top_country')->nullable()->comment('Country with the most visitors');
            $table->string('top_region')->nullable()->comment('Region with the most visitors');
            $table->string('top_language')->nullable()->comment('Most frequently used language');
            $table->string('top_agent')->nullable()->comment('Most frequently used user agent (browser)');
            $table->timestamps();

            $table->index('date')->comment('Index to optimize queries based on date');
            $table->index('associated_domain_id')->comment('Index to optimize queries based on associated domain');
        });
    }

    /**
     * Reverse the migrations by dropping the daily_stats table.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_stats_google');
    }
};

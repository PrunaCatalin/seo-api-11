<?php

/*
 * ${PROJECT_NAME} | 2024_03_04_150507_monthly_stats.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 04.03.2024 15:05
*/

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection('stats')->create('monthly_stats_google', function (Blueprint $table) {
            $table->id()->comment('Unique identifier for each monthly stats record');
            $table->year('year')->comment('Year of the aggregated statistics');
            $table->tinyInteger('month')->comment('Month of the aggregated statistics');
            $table->bigInteger('associated_domain_id')->comment('Domain ID to group statistics by domain');
            $table->string('tenant_id')->comment('Tenant identifier, for multi-tenant statistics');
            $table->integer('sessions_count')->default(0)->comment('Total number of sessions for the month');
            $table->integer('unique_visitors')->default(0)->comment(
                'Estimated number of unique visitors for the month'
            );
            $table->integer('page_views')->default(0)->comment('Total page views for the month');
            $table->integer('events_count')->default(0)->comment('Total number of recorded events for the month');
            $table->string('top_keyword')->nullable()->comment('Most frequent search keyword for the month');
            $table->string('top_country')->nullable()->comment('Country with the most visitors for the month');
            $table->string('top_region')->nullable()->comment('Region with the most visitors for the month');
            $table->string('top_language')->nullable()->comment('Most frequently used language for the month');
            $table->string('top_agent')->nullable()->comment('Most frequently used user agent (browser) for the month');
            $table->timestamps();

            $table->index(['year', 'month'])->comment('Index to optimize queries based on year and month');
            $table->index('associated_domain_id')->comment('Index to optimize queries based on associated domain');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monthly_stats_google');
    }
};

<?php

/*
 * seo-api | YearlyStatsGoogle.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email: office@webdirect.ro
 * Type: Javascript
 * Created on: 3/4/2024 5:43 PM
*/

namespace Modules\Tenants\App\Models\Stats;

use Illuminate\Database\Eloquent\Model;

class YearlyStatsGoogle extends Model
{
    protected $connection = 'stats';
    protected $table = 'yearly_stats_google';
    protected $fillable = [
        'year',
        'associated_domain_id',
        'tenant_id',
        'sessions_count',
        'unique_visitors',
        'page_views',
        'events_count',
        'top_keyword',
        'top_country',
        'top_region',
        'top_language',
        'top_agent',
    ];

    public $timestamps = true;

    // Define relationships here
}

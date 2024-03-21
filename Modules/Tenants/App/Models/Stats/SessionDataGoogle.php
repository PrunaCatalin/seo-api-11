<?php

/*
 * seo-api | SessionDataGoogle.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email: office@webdirect.ro
 * Type: Javascript
 * Created on: 3/4/2024 5:41 PM
*/

namespace Modules\Tenants\App\Models\Stats;

use Illuminate\Database\Eloquent\Model;

class SessionDataGoogle extends Model
{
    // Explicitly define the connection name if it's not the default connection
    protected $connection = 'stats';

    // Define the table name explicitly if it's not the pluralized form of model name
    protected $table = 'session_data_google';

    // Mass assignable attributes for ease of creating/updating
    protected $fillable = [
        'associated_domain_id',
        'tenant_id',
        'unique_visitors',
        'page_views',
        'title',
        'language',
        'region',
        'country',
        'keyword',
        'agent',
        'event',
        'architecture',
        'screen_resolution',
        'date',
    ];

    // Indicates if the model should be timestamped. (true by default)
    public $timestamps = true;

    /**
     * Write your model relationships here,
     * For example, if a session belongs to a domain, you can define a belongsTo relationship
     */

    // Example relationship
    // public function domain() {
    //     return $this->belongsTo(Domain::class, 'associated_domain_id');
    // }
}

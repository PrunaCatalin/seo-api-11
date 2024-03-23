<?php

/*
 * seo-api | CustomerDomain.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email: office@webdirect.ro
 * Type: Javascript
 * Created on: 3/4/2024 5:48 PM
*/

namespace Modules\Tenants\App\Models\Customer;

use Database\Factories\CustomerDomainFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Modules\Tenants\App\Models\Stats\SessionDataGoogle;

class CustomerDomain extends Model
{
    use SoftDeletes;
    use HasFactory;

    // Enable soft deletes for the model
    // Explicitly define the connection name if it's not the default connection
    protected $connection = 'mysql';
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'customer_domains';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id',
        'domain',
        'tenant_id',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public static function newFactory()
    {
        return CustomerDomainFactory::new();
    }

    /**
     * Get the customer that owns the domain.
     *
     * This establishes a one-to-many (inverse) relationship between the CustomerDomain
     * and the Customer models. It assumes that the Customer model exists and has a
     * corresponding 'id' that customer_domains.customer_id references.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function sessionData()
    {
        return $this->hasMany(SessionDataGoogle::class, 'associated_domain_id', 'id');
    }

    public function getDailyStatsRecords()
    {
        $tenantId = $this->tenant_id;
        $prefix = config('tenants.prefix_stats');
        return DB::connection('stats')->table($prefix . 'daily_stats_google')
            ->where('associated_domain_id', $this->id)
            ->get();
    }

    public function getMontlyStatsRecords()
    {
        $tenantId = $this->tenant_id;
        $prefix = config('tenants.prefix_stats');
        return DB::connection('stats')->table($prefix . 'monthly_stats_google')
            ->where('associated_domain_id', $this->id)
            ->get();
    }

    public function getYearlyStatsRecords()
    {
        $tenantId = $this->tenant_id;
        $prefix = config('tenants.prefix_stats');
        return DB::connection('stats')->table($prefix . 'yearly_stats_google')
            ->where('associated_domain_id', $this->id)
            ->get();
    }

    // Add any additional relationships or functionality below as needed.
}

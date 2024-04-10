<?php
/*
 * seo-api | CustomerReferral.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 3/26/2024 8:03 PM
*/

namespace Modules\Tenants\App\Models\Customer;

use Illuminate\Database\Eloquent\Model;

class CustomerReferral extends Model
{
    protected $table = 'customer_referral';


    /**
     * Get the customer who made the referral.
     */
    public function referrer()
    {
        return $this->belongsTo(Customer::class, 'referrer_id');
    }

    /**
     * Get the customer who was referred.
     */
    public function referred()
    {
        return $this->belongsTo(Customer::class, 'referred_id');
    }
}

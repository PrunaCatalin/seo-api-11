<?php

/*
 * wdirect-api | Order.php
 * https://www.webdirect.ro/
 * Copyright 2023 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 12/9/2023 9:14 PM
*/

namespace Modules\Tenants\App\Models\Order;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Tenants\App\Models\Currency\Currency;
use Modules\Tenants\App\Models\Customer\Customer;
use Modules\Tenants\App\Models\Customer\CustomerCompany;
use Modules\Tenants\App\Models\Product\Product;

class Order extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id',
        'currency_id',
        'shipment_id',
        'customer_company_id',
        'status',
        'total_price'
    ];

    /**
     * Get the customer associated with the order.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * Get the currency associated with the order.
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    /**
     * Get the company associated with the order (optional).
     */
    public function customerCompany()
    {
        return $this->belongsTo(CustomerCompany::class, 'customer_company_id');
    }
    

    /**
     * Get the order's shipment details.
     */
    public function shipment()
    {
        return $this->hasOne(OrderShipment::class, 'shipment_id');
    }

    /**
     * Get the total price attribute.
     *
     * @return string
     */
    public function getTotalPriceAttribute($value)
    {
        // You can format the price here if needed
        return number_format($value, 2);
    }
}

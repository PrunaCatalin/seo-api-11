<?php

/*
 * wdirect-api | OrderShipment.php
 * https://www.webdirect.ro/
 * Copyright 2023 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 12/9/2023 9:18 PM
*/

namespace Modules\Tenants\App\Models\Order;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Tenants\App\Models\Customer\CustomerAddress;

class OrderShipment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'order_id',
        'customer_address_id',
        'carrier',
        'tracking_number',
        'shipped_at'
    ];

    /**
     * Get the order associated with the shipment.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the customer address associated with the shipment.
     */
    public function customerAddress()
    {
        return $this->belongsTo(CustomerAddress::class);
    }
}

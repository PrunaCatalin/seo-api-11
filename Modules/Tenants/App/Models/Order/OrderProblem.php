<?php
/*
 * seo-api | OrderProblem.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 4/28/2024 8:52 PM
*/

namespace Modules\Tenants\App\Models\Order;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderProblem extends Model
{
    protected $table = 'orders_problems';

    protected $fillable = [
        'order_id',
        'type',
        'description',
        'status'
    ];

    protected $casts = [
        'order_id' => 'int',
        'type' => 'string',
        'description' => 'string',
        'status' => 'string'
    ];

    /**
     * Get the order that the problem is associated with.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

}

<?php

/*
 * wdirect-api | OrderHistory.php
 * https://www.webdirect.ro/
 * Copyright 2023 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 12/10/2023 4:07 PM
*/

namespace Modules\Tenants\App\Models\Order;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Admin\Models\Users\User;

class OrderHistory extends Model
{
    use SoftDeletes;

    protected $table = 'order_histories';

    protected $fillable = [
        'order_id',
        'status',
        'comment',
        'changed_by'
    ];

    /**
     * Get the order that the history belongs to.
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /**
     * Get the user who made the change.
     */
    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}

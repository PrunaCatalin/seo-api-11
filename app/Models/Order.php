<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Tenants\App\Models\Order\Order as TenantOrder;

class Order extends TenantOrder
{
    use HasFactory;
}

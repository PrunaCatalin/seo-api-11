<?php
/*
 * seo-api | OrderStatus.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 4/27/2024 7:55 PM
*/

namespace Modules\Tenants\App\Enums\Order;

enum OrderStatus: string
{
    case Pending = 'Pending';
    case Processing = 'Processing';
    case OnHold = 'On Hold';
    case Shipped = 'Shipped';
    case Delivered = 'Delivered';
    case Cancelled = 'Cancelled';
    case Refunded = 'Refunded';
    case Failed = 'Failed';
    case Completed = 'Completed';
}

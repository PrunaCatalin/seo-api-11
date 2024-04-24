<?php
/*
 * seo-api | SubscriptionStatus.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 4/23/2024 10:52 PM
*/

namespace Modules\Tenants\App\Enums\Subscription;

enum SubscriptionStatus: string
{
    case ACTIVE = 'active';
    case PENDING = 'pending';
    case EXPIRED = 'expired';
    case CANCELED = 'canceled';
    case CANCELED_BY_CLIENT = 'canceled-by_client';
}

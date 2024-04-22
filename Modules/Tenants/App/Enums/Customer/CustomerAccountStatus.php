<?php
/*
 * seo-api | CustomerStatusEnum.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 4/21/2024 9:38 AM
*/

namespace Modules\Tenants\App\Enums\Customer;

enum CustomerAccountStatus: string
{
    case OPEN = 'open';
    case PENDING = 'pending';
    case BLOCKED = 'blocked';
}

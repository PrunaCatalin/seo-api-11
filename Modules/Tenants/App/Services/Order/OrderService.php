<?php
/*
 * seo-api | OrderService.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 4/27/2024 9:39 AM
*/

namespace Modules\Tenants\App\Services\Order;

use Modules\Tenants\App\Contracts\CrudMicroService;

class OrderService implements CrudMicroService
{

    public function create(array $data)
    {
        if (isset($data['customer_id']) && is_numeric($data['customer_id'])) {
        }
    }

    public function update(array $data)
    {
        // TODO: Implement update() method.
    }

    public function delete(array $data)
    {
        // TODO: Implement delete() method.
    }


}

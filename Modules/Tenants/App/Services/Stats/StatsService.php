<?php
/*
 * seo-api | StatsService.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 3/22/2024 2:18 PM
*/

namespace Modules\Tenants\App\Services\Stats;

use Illuminate\Support\Facades\DB;
use Modules\Tenants\App\Contracts\CrudMicroService;
use Modules\Tenants\App\Models\Customer\Customer;
use Modules\Tenants\App\Models\Customer\CustomerDomain;

class StatsService implements CrudMicroService
{
    public function totalDomainsByCustomer(Customer $customer)
    {
        return CustomerDomain::select([
            'domain',
            DB::raw(
                '(
                    select count(*) from `webdirec_seo_stats`.`seo_session_data_google`
                 where `seo_customer_domains`.`id` = `seo_session_data_google`.`associated_domain_id`
                 ) as `session_data_count`'
            )
        ])->where('customer_id', $customer->id)->get();
    }

    public function create(array $data)
    {
        // TODO: Implement create() method.
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

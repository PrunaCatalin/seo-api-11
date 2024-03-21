<?php

/*
 * seo-api | CustomerContactService.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email: office@webdirect.ro
 * Type: Javascript
 * Created on: 3/11/2024 9:02 PM
*/

namespace Modules\Tenants\App\Services\Customer;

use Illuminate\Support\Facades\Mail;
use Modules\Tenants\App\Emails\AdminContactNotificationMail;
use Modules\Tenants\App\Emails\CustomerContactConfirmationMail;
use Modules\Tenants\App\Models\Customer\Customer;

class CustomerContactService
{
    /*
     * Reminder - all emails need to go on queue to avoid overloading the server mail
     */
    public function sendContact(array $data, ?Customer $customer)
    {
        //Confirmation to an admin
        Mail::to(config('tenants.contactEmail'))->queue(new AdminContactNotificationMail($data, $customer));
        //Confirmation to a customer
        Mail::to($customer->email)->queue(new CustomerContactConfirmationMail($data, $customer));
        return true;
    }
}

<?php

/**
 * File Name: CustomerController.php
 * Author: CATALIN PRUNA
 * Created: 7/9/2023
 *
 * License:
 * --------------
 * SC WEBDIRECT TEHNOLOGIES SRL
 *
 * Change Log:
 * --------------
 * Date| Author| Description
 * 7/9/2023 | CATALIN PRUNA | Initial version
 *
 */

namespace Modules\Tenants\App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Tenants\App\Http\Requests\Customer\ContactRequest;
use Modules\Tenants\App\Models\Customer\Customer;
use Modules\Tenants\App\Services\Customer\CustomerContactService;
use Modules\Tenants\App\Services\Customer\CustomerService;
use Modules\Tenants\App\Exceptions\ServiceException;

class CustomerController extends Controller
{
    public function __construct(
        private readonly CustomerService $customerService,
        private readonly CustomerContactService $customerContactService
    ) {
    }

    public function info()
    {
        try {
            $customer = $this->customerService->find(auth('customer')->user()->id);
            return response()->json([
                'status' => 'success',
                'info' => $customer
            ]);
        } catch (ServiceException $e) {
            return response()->json([
                'status' => false,
                'errors' => $e->getMessage()
            ]);
        }
    }

    /**
     * @param ContactRequest $request
     * @return JsonResponse
     */
    public function sendContact(ContactRequest $request)
    {
        $request = $request->validated();
        try {
            $this->customerContactService->sendContact([
                'subject' => $request['subject'],
                'message' => $request['message']
            ], Customer::with('customerDetails')->find(auth('sanctum')->user()->id));
        } catch (ServiceException $e) {
            return response()->json([
                'status' => false,
                'errors' => $e->getMessage()
            ]);
        }
        return response()->json([
            'status' => true
        ]);
    }
}

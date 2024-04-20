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
use Modules\Tenants\App\Http\Requests\Customer\UpdateProfileRequest;
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
            $customer = $this->customerService->find(id: auth('customer')->user()->id);
            return response()->json(data: [
                'status' => 'success',
                'info' => $customer
            ]);
        } catch (ServiceException $e) {
            return response()->json(data: [
                'status' => false,
                'errors' => $e->getMessage()
            ]);
        }
    }

    public function addresses()
    {
    }

    public function updateProfile(UpdateProfileRequest $updateProfileRequest)
    {
        try {
            $customer = $this->customerService->update(
                data: $updateProfileRequest->validated(),
                customerId: auth('customer')->user()->id,
                type: 'profile'
            );
            return response()->json(data: [
                'status' => 'success',
                'info' => $customer
            ]);
        } catch (ServiceException $e) {
            return response()->json(data: [
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
            $this->customerContactService->sendContact(
                data: [
                    'subject' => $request['subject'],
                    'message' => $request['message']
                ],
                customer: Customer::with('customerDetails')->find(id: auth('sanctum')->user()->id)
            );
        } catch (ServiceException $e) {
            return response()->json(data: [
                'status' => false,
                'errors' => $e->getMessage()
            ]);
        }
        return response()->json(data: [
            'status' => true
        ]);
    }
}

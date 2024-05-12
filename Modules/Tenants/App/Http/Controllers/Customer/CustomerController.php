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
use Illuminate\Support\Facades\Log;
use Modules\Tenants\App\Http\Requests\Customer\AddressRequest;
use Modules\Tenants\App\Http\Requests\Customer\ContactRequest;
use Modules\Tenants\App\Http\Requests\Customer\UpdateProfileRequest;
use Modules\Tenants\App\Models\Customer\Customer;
use Modules\Tenants\App\Services\Customer\CustomerCompanyService;
use Modules\Tenants\App\Services\Customer\CustomerContactService;
use Modules\Tenants\App\Services\Customer\CustomerDomainService;
use Modules\Tenants\App\Services\Customer\CustomerService;
use Modules\Tenants\App\Exceptions\ServiceException;

class CustomerController extends Controller
{
    public function __construct(
        private readonly CustomerService $customerService,
        private readonly CustomerContactService $customerContactService,
        private readonly CustomerCompanyService $customerCompanyService,
        private readonly CustomerDomainService $customerDomainService,
    ) {
    }

    /**
     * @return JsonResponse
     */
    public function info()
    {
        try {
            $customer = $this->customerService->find(id: auth('customer')->user()->id);
            return response()->json(data: [
                'status' => 'success',
                'data' => $customer
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

    /**
     * @param AddressRequest $addressRequest
     * @return JsonResponse
     */
    public function companies(AddressRequest $addressRequest)
    {
        try {
            $addresses = $this->customerCompanyService->findAll(
                customerId: auth('customer')->user()->id,
                data: $addressRequest->validated()
            );
            return response()->json(data: [
                'status' => 'success',
                'list' => $addresses
            ]);
        } catch (ServiceException $e) {
            return response()->json(data: [
                'status' => false,
                'errors' => $e->getMessage()
            ]);
        }
    }

    /**
     * @return JsonResponse
     */
    public function domains()
    {
        try {
            $domains = $this->customerDomainService->findAllDomains(
                customerId: auth('customer')->user()->id
            );
            $customer = $this->customerService->find(id: auth('customer')->user()->id);
            $canAddDomain = $customer->currentPlan();
            return response()->json(data: [
                'status' => 'success',
                'list' => $domains,
                'canAddDomain' => ($canAddDomain->pivot->no_domains > count($domains)),
            ]);
        } catch (ServiceException $e) {
            return response()->json(data: [
                'status' => false,
                'errors' => $e->getMessage()
            ]);
        }
    }

    /**
     * @param UpdateProfileRequest $updateProfileRequest
     * @return JsonResponse
     */
    public function syncInfo(UpdateProfileRequest $updateProfileRequest)
    {
        try {
            $this->customerService->syncInfo(
                data: $updateProfileRequest->validated(),
                customerId: auth('customer')->user()->id
            );
            return response()->json(data: [
                'status' => 'success',
                'message' => 'Update profile success'
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

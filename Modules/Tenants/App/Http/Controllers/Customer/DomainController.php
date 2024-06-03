<?php
/*
 * ${PROJECT_NAME} | DomainController.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 13:18
*/

namespace Modules\Tenants\App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Tenants\App\Exceptions\ServiceException;
use Modules\Tenants\App\Http\Requests\Customer\CreateDomainRequest;
use Modules\Tenants\App\Services\Customer\CustomerDomainService;
use Modules\Tenants\App\Services\Customer\CustomerService;

class DomainController extends Controller
{
    public function __construct(private readonly CustomerService       $customerService,
                                private readonly CustomerDomainService $customerDomainService)
    {
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
                'canAddDomain' => (empty($canAddDomain->pivot) || $canAddDomain->max_domains > count($domains)),
            ]);
        } catch (ServiceException $e) {
            return response()->json(data: [
                'status' => false,
                'errors' => $e->getMessage()
            ]);
        }
    }

    /**
     * @param int $domainId
     * @return JsonResponse
     */
    public function deleteDomain(int $domainId)
    {
        try {
            $this->customerDomainService->deleteDomain(
                customer: auth('customer')->user(),
                domainId: $domainId
            );
            return response()->json(data: [
                'status' => 'success'
            ]);
        } catch (ServiceException $e) {
            return response()->json(data: [
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * @param CreateDomainRequest $request
     * @return JsonResponse
     */
    public function createDomain(CreateDomainRequest $request)
    {
        try {
            $this->customerDomainService->createDomain(
                customer: auth('customer')->user(),
                domainName: $request->name
            );
            return response()->json(data: [
                'status' => 'success'
            ]);
        } catch (ServiceException $e) {
            return response()->json(data: [
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}

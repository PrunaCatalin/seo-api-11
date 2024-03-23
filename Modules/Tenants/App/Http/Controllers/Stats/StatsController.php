<?php
/*
 * ${PROJECT_NAME} | StatsController.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 22.03.2024 14:08
*/

namespace Modules\Tenants\App\Http\Controllers\Stats;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Modules\Tenants\App\Exceptions\ServiceException;
use Modules\Tenants\App\Services\Stats\StatsService;

class StatsController extends Controller
{
    public function __construct(protected readonly StatsService $statsService)
    {
    }

    /**
     * @return JsonResponse
     */
    public function dashboard()
    {
        try {
            $customer = $this->statsService->totalDomainsByCustomer(auth('sanctum')->user());
            return response()->json([
                'status' => true,
                'statistics' => $customer
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'errors' => $e->getMessage()
            ]);
        }
    }
}

<?php
/*
 * ${PROJECT_NAME} | WalletController.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 28.03.2024 15:54
*/

namespace Modules\Tenants\App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Modules\Tenants\App\Enums\Customer\CustomerAccountStatus;
use Modules\Tenants\App\Exceptions\ServiceException;
use Modules\Tenants\App\Models\Customer\Customer;
use Modules\Tenants\App\Services\Customer\WalletService;

class WalletController extends Controller
{
    public function __construct(protected readonly WalletService $walletService)
    {
    }

    /**
     * @return JsonResponse
     */
    public function index()
    {
        // Retrieve the authenticated user's ID
        $userId = auth('sanctum')->user()->id;

        $wallet = $this->walletService->getWallet(Customer::find($userId));
        return response()->json([
            'response' => $wallet,
            'status' => 'success'
        ]);
    }
}

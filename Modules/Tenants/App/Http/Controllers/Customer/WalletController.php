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
//        Log::debug('DEb ug: ' . $userId);

        // Define a unique cache key based on the user's ID
        // This ensures each user's wallet data is cached separately
        $cacheKey = 'wallet_data_for_user_' . $userId;

        // Attempt to retrieve the wallet data from the cache
        $wallet = Cache::remember($cacheKey, 3600, function () use ($userId) {
            // Fallback logic if the data isn't in the cache
            // For example: Fetch wallet data from an external service or the database
            // Note: It's important to handle the possibility that Customer::find($userId)
            // might return null. Ensure your walletService->getWallet method can handle such cases.
            return $this->walletService->getWallet(Customer::find($userId));
        });

        // Return a JSON response with the wallet data
        // If the data was in cache, it's returned immediately.
        // Otherwise, the data retrieved in the fallback logic is returned and also cached for future requests.
        return response()->json([
            'response' => $wallet,
            'status' => 'success'
        ]);
    }
}

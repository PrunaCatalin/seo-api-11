<?php
/*
 * ${PROJECT_NAME} | CheckAccountStatusMiddleware.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 21.04.2024 10:52
*/

namespace Modules\Tenants\App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Tenants\App\Enums\Customer\CustomerAccountStatus;

class CheckAccountStatusMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $customer = auth('sanctum')->user();

        if ($customer && $customer->account_status == CustomerAccountStatus::BLOCKED->value) {
            $customer->tokens()->where('tokenable_id', $customer->id)->delete();
            return response()->json([
                'response' => 'Account is blocked',
                'status' => false
            ]);
        }
        return $next($request);
    }
}

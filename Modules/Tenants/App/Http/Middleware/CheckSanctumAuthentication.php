<?php

namespace Modules\Tenants\App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckSanctumAuthentication
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (Str::startsWith($request->getRequestUri(), '/api/v1/admin/')) {
            config(['sanctum.guard' => 'admin']);
        } elseif (Str::startsWith($request->getRequestUri(), '/api/v1/')) {
            config(['sanctum.guard' => 'customer']);
        }
        return $next($request);
    }
}

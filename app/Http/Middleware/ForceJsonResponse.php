<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceJsonResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);  // after request completion get the controller response her
        if ($response instanceof \Illuminate\Http\JsonResponse) {
            $current_data = $response->getData();
//            $current_data->SalesforceUser = (new SalesforceApiServices())->infoToken();
            $response->setData($current_data);
        }
        return $next($request);
    }
}

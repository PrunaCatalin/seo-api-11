<?php

use App\Http\Middleware\ForceJsonResponse;
use App\Http\Middleware\IdentifyTenant;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Log;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        // channels: __DIR__ . '/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->validateCsrfTokens(except: [
            'stripe/*',
            'paddle/*'
        ]);
        $middleware->alias([
            'json.response' => ForceJsonResponse::class,
            'identifyTenant' => IdentifyTenant::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
        //Log::channel('slack')->alert('SeoApi Exceptions', (array)$exceptions);
    })->create();

<?php

namespace Modules\Tenants\App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The module namespace to assume when generating URLs to actions.
     */
    protected string $moduleNamespace = 'Modules\Tenants\App\Http\Controllers';

    /**
     * Called before routes are registered.
     *
     * Register any model bindings or pattern based filters.
     */
    public function boot(): void
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     */
    public function map(): void
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     */
    protected function mapWebRoutes(): void
    {
        Route::middleware('web')
            ->namespace($this->moduleNamespace)
            ->group(module_path('Tenants', '/routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     */
    protected function mapApiRoutes(): void
    {
//        foreach ($this->centralDomains() as $domain) {
        $domain = config('app.appHostNameTenant');
        Route::prefix('api/v1')
            ->middleware(['api', 'identifyTenant'])
            ->domain($domain)
            ->namespace($this->moduleNamespace)
            ->group(function () use ($domain) {
                require module_path('Tenants', 'routes/customer/auth.php');
                require module_path('Tenants', 'routes/location/location.php');
                Route::middleware(['auth:sanctum'])
                    ->prefix('customer')
                    ->domain($domain)
                    ->namespace($this->moduleNamespace)
                    ->group(function () use ($domain) { // only logged customer
                        require module_path('Tenants', '/routes/subscription/subscription.php');
                        require module_path('Tenants', 'routes/customer/customer.php');
                    });
                Route::middleware(['auth:sanctum'])
                    ->prefix('payments')
                    ->domain($domain)
                    ->namespace($this->moduleNamespace)
                    ->group(function () use ($domain) { // only logged customer
                        require module_path('Tenants', '/routes/payments/payment.php');
                    });
                Route::middleware(['auth:sanctum'])
                    ->prefix('stats')
                    ->domain($domain)
                    ->namespace($this->moduleNamespace)
                    ->group(function () use ($domain) { // only logged customer
                        require module_path('Tenants', 'routes/stats/stats.php');
                    });
            });
//        }
    }

    /**
     * @return array
     */
    protected function centralDomains(): array
    {
        return config('tenancy.central_domains');
    }
}

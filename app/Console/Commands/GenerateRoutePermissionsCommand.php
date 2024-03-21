<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class GenerateRoutePermissionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permissions:generate {--module=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate specific permissions for all existing routes';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Get all defined routes in the application
        $routes = Route::getRoutes();
        $module = $this->option('module');
        if ($module) {
            $module = "\\" . $module;
        }
        // Get the route iterator and convert it to an array
        $routeArray = iterator_to_array($routes->getIterator());

        // Filter out routes that come from vendor packages
        $filteredRoutes = array_filter($routeArray, function ($route) use ($module) {
            $action = $route->getAction();

            // Ignore routes that don't have an action or a namespace
            if (!isset($action['controller']) || !isset($action['namespace'])) {
                return false;
            }
            // Check if the namespace starts with "App\" or "App\Http\Controllers\"

            if (
                str_starts_with($action['namespace'], 'App') ||
                str_starts_with($action['namespace'], 'Modules' . $module)
            ) {
                return true;
            }
            return false;
        });
        // Define the specific permission actions

        // Iterate through the routes and create permissions for each route
        foreach ($filteredRoutes as $route) {
            // Filter out routes that come from vendor packages

            // Get the route name or use a default value
            $routeName = $route->getName() ?? 'unnamed.route';

            // Iterate through the specific actions and create permissions
            // foreach ($actions as $action) {
            if (!preg_match("/login|logout/", $routeName, $find)) {
                $permissionName = "{$routeName}";

                // Check if the permission already exists in the database
                $existingPermission = Permission::where('name', $routeName)->first();

                // If it doesn't exist, create a new permission
                if (!$existingPermission) {
                    Permission::create(['name' => $routeName]);
                    $this->info("Permission created: {$permissionName}");
                } else {
                    $this->line("Permission already exists: {$permissionName}");
                }
            }
            // }
        }
        // Create the admin role
        $admin = Role::firstOrCreate(['name' => 'admin']);
        // Get all permissions
        $permissions = Permission::all();
        // Give the admin role all permissions
        $admin->givePermissionTo($permissions);
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        $this->info('All specific permissions for existing routes have been generated.');
    }
}

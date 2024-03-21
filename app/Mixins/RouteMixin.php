<?php
/*
 * API NED CURIER | RouteMixin.php
 * https://www.webdirect.ro/
 * Copyright 2022 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 11/7/2022 9:11 AM
*/

namespace App\Mixins;
use Illuminate\Support\Facades\Route;
class RouteMixin
{
    public function routeList()
    {
        return function () {
            return collect(Route::getRoutes())->map(function ($route) {
                return [
                    'host'   => $route->domain(),
                    'method' => implode('|', $route->methods()),
                    'uri'    => $route->uri(),
                    'name'   => $route->getName(),
                    'action' => $route->getActionName()
                ];
            });
        };
    }
}

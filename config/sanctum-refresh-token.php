<?php
/*
 * API NED CURIER | sanctum-refresh-token.php
 * https://www.webdirect.ro/
 * Copyright 2022 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 11/21/2022 11:45 PM
*/
return [
    /*
    |--------------------------------------------------------------------------
    | Refresh Route Names
    |--------------------------------------------------------------------------
    |
    | This value controls the used refresh route names
    |
    */
    'refresh_route_names' => 'api.token.refresh',

    /*
    |--------------------------------------------------------------------------
    | Expiration Minutes
    |--------------------------------------------------------------------------
    |
    | This value controls the number of minutes until an issued tokens will be
    | considered expired.
    |
    */
    'auth_token_expiration'    => 60,
    'refresh_token_expiration' => 5,
];

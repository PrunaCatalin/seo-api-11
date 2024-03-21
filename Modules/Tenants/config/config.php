<?php

return [
    'name' => 'Tenants',
    'appUrl' => env('API_URL', 'api'),
    'storage' => [
        'path' => '',
        'clients' => 'clients',
    ],
    'prefix_stats' => 'seo_',
    'contactEmail' => env('MAIL_USERNAME', 'default'),
    'contactName' => env('MAIL_FROM_NAME', 'default'),
    'convert' => [
        'service' => env('EXCHANGE_RATE_SERVICE', 'infovalutar')
    ]
];

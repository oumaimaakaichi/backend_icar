<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie' , 'api/demande' ,'api/tickets/*','api/catalogues/*' , 'api/paniers/*' , 'storage/*' , 'api/panier/*' ],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['*'],
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false,
];

<?php

return [
    'defaults' => [
        'guard' => 'web', // Ne pas utiliser env() ici pour éviter les conflits
        'passwords' => 'users',
    ],

    'guards' => [
        'api' => [
            'driver' => 'jwt',
            'provider' => 'users',
        ],
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        'atelier' => [
            'driver' => 'session',
            'provider' => 'ateliers',
        ],
        'entreprise' => [
            'driver' => 'session',
            'provider' => 'entreprises',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],
        'ateliers' => [
            'driver' => 'eloquent',
            'model' => App\Models\Atelier::class,
        ],
        'entreprises' => [
            'driver' => 'eloquent',
            'model' => App\Models\EntrepriseContractante::class,
        ],
    ],

   'passwords' => [
    'users' => [
        'provider' => 'users',
        'table' => 'password_reset_tokens',
        'expire' => 60,
        'throttle' => 60,
    ],
    'ateliers' => [
        'provider' => 'ateliers',
        'table' => 'atelier_password_resets',
        'expire' => 60,
        'throttle' => 60,
    ],
    'entreprises' => [
        'provider' => 'entreprises',
        'table' => 'entreprise_password_resets',
        'expire' => 60,
        'throttle' => 60,
    ],
],

    'password_timeout' => 10800, // 3 heures en secondes
];

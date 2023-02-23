<?php

return  [
    /*
    |--------------------------------------------------------------------------
    | MTN Configurations
    |--------------------------------------------------------------------------
    |
    | The configurations for MTN.
    |
    */
    'wave' => [
        'url' => env("BASE_URL"),
        'public_key' => env("PUBLIC_KEY"),
        'secret_key' => env("SECRET_KEY"),
        'encryption_key' => env("ENCRYPTION_KEY"),
    ],
];



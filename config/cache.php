<?php

return [
    'default' => env('CACHE_DRIVER', 'array'),
    'stores' => [
        'array' => [
            'driver' => 'array',
        ],
        'file' => [
            'driver' => 'file',
            'path' => storage_path('framework/cache/data'),
            'lock_path' => storage_path('framework/cache/data'),
        ],
        'none' => [
            'driver' => 'null',
        ],
    ],
    'prefix' => env('CACHE_PREFIX', 'laravel_cache'),
];

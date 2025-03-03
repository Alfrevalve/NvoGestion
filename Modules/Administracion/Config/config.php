<?php

return [
    'name' => 'Administracion',
    'description' => 'Módulo de administración del sistema',
    'display_name' => 'Administración',
    'order' => 4,
    'enabled' => true,
    'menu' => [
        [
            'text' => 'Usuarios',
            'url'  => '/admin/users',
            'icon' => 'fas fa-users',
            'can'  => 'ver usuarios'
        ],
        [
            'text' => 'Roles',
            'url'  => '/admin/roles',
            'icon' => 'fas fa-user-shield',
            'can'  => 'gestionar roles'
        ],
        [
            'text' => 'Permisos',
            'url'  => '/admin/permissions',
            'icon' => 'fas fa-key',
            'can'  => 'gestionar roles'
        ],
        [
            'text' => 'Configuración',
            'url'  => '/admin/configuraciones',
            'icon' => 'fas fa-cogs',
            'can'  => 'ver configuracion'
        ],
        [
            'text' => 'Logs del Sistema',
            'url'  => '/admin/logs',
            'icon' => 'fas fa-history',
            'can'  => 'ver configuracion'
        ],
        [
            'text' => 'Respaldos',
            'url'  => '/admin/backups',
            'icon' => 'fas fa-database',
            'can'  => 'ver configuracion'
        ]
    ],
    'settings' => [
        'company_name' => 'NvoGestion',
        'company_address' => '',
        'company_phone' => '',
        'company_email' => '',
        'company_logo' => 'images/logo.png',
        'default_pagination' => 10,
        'enable_notifications' => true,
        'enable_activity_log' => true,
        'enable_backups' => true,
        'backup_schedule' => 'daily',
        'backup_retention_days' => 7,
        'timezone' => 'America/Argentina/Buenos_Aires',
        'date_format' => 'd/m/Y',
        'time_format' => 'H:i',
        'currency' => 'ARS',
        'decimal_separator' => ',',
        'thousand_separator' => '.',
        'decimal_places' => 2,
    ]
];

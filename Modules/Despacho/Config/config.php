<?php

return [
    'name' => 'Despacho',
    'description' => 'Módulo de gestión de despachos y entregas',
    'display_name' => 'Despacho',
    'order' => 3,
    'enabled' => true,
    'menu' => [
        [
            'text' => 'Despachos',
            'url'  => '/despacho',
            'icon' => 'fas fa-truck-loading',
            'can'  => 'ver despachos'
        ],
        [
            'text' => 'Entregas',
            'url'  => '/despacho/entregas',
            'icon' => 'fas fa-dolly',
            'can'  => 'ver despachos'
        ],
        [
            'text' => 'Rutas',
            'url'  => '/despacho/rutas',
            'icon' => 'fas fa-route',
            'can'  => 'ver despachos'
        ],
        [
            'text' => 'Reportes',
            'url'  => '/despacho/reportes',
            'icon' => 'fas fa-chart-bar',
            'can'  => 'ver despachos'
        ]
    ]
];

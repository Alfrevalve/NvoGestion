<?php

return [
    'name' => 'Almacen',
    'description' => 'Módulo de gestión de inventario y almacén',
    'display_name' => 'Almacén',
    'order' => 2,
    'enabled' => true,
    'menu' => [
        [
            'text' => 'Inventario',
            'url'  => '/almacen',
            'icon' => 'fas fa-boxes',
            'can'  => 'ver inventario'
        ],
        [
            'text' => 'Categorías',
            'url'  => '/almacen/categorias',
            'icon' => 'fas fa-tags',
            'can'  => 'ver inventario'
        ],
        [
            'text' => 'Proveedores',
            'url'  => '/almacen/proveedores',
            'icon' => 'fas fa-truck',
            'can'  => 'ver inventario'
        ],
        [
            'text' => 'Movimientos',
            'url'  => '/almacen/movimientos',
            'icon' => 'fas fa-exchange-alt',
            'can'  => 'ver inventario'
        ]
    ]
];

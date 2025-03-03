<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    */

    'title' => 'NvoGestion',
    'title_prefix' => '',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    */

    'use_ico_only' => false,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    */

    'logo' => '<b>Nvo</b>Gestion',
    'logo_img' => 'images/logo.png',
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'NvoGestion',

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    */

    'usermenu_enabled' => true,
    'usermenu_header' => false,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => false,
    'usermenu_desc' => false,
    'usermenu_profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => true,
    'layout_fixed_navbar' => true,
    'layout_fixed_footer' => null,
    'layout_dark_mode' => null,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    */

    'classes_auth_card' => 'card-outline card-info',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    */

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-navy elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    */

    'menu' => [
        // Dashboard
        [
            'text' => 'Dashboard',
            'url'  => '/',
            'icon' => 'fas fa-fw fa-tachometer-alt',
        ],

        // Cirugías (sección actualizada con todas las opciones)
        [
            'text'    => 'Cirugías',
            'icon'    => 'fas fa-fw fa-procedures',
            'submenu' => [
                [
                    'text' => 'Lista de Cirugías',
                    'url'  => 'modulo-cirugias',
                    'icon' => 'fas fa-fw fa-list'
                ],
                [
                    'text' => 'Nueva Cirugía',
                    'url'  => 'modulo-cirugias/create',
                    'icon' => 'fas fa-fw fa-plus',
                ],
                [
                    'text' => 'Calendario',
                    'url'  => 'modulo-cirugias/calendario',
                     'icon' => 'fas fa-fw fa-calendar-alt'
                ],
                [
                    'text' => 'Kanban',
                    'url'  => 'modulo-cirugias/kanban',
                    'icon' => 'fas fa-fw fa-tasks'
                ],
                [
                    'text' => 'Reportes',
                    'url'  => 'modulo-cirugias/reportes',
                    'icon' => 'fas fa-fw fa-file-alt'
                ],
                [
                    'text' => 'Instituciones',
                    'url'  => 'modulo-cirugias/instituciones',
                    'icon' => 'fas fa-fw fa-building'
                ],
                [
                    'text' => 'Médicos',
                    'url'  => 'modulo-cirugias/medicos',
                    'icon' => 'fas fa-fw fa-user-md'
                ],
                [
                    'text' => 'Instrumentistas',
                    'url'  => 'modulo-cirugias/instrumentistas',
                    'icon' => 'fas fa-fw fa-user-nurse'
                ],
                [
                    'text' => 'Equipos',
                    'url'  => 'modulo-cirugias/equipos',
                    'icon' => 'fas fa-fw fa-toolbox'
                ],
                [
                    'text' => 'Materiales',
                    'url'  => 'modulo-cirugias/materiales',
                    'icon' => 'fas fa-fw fa-prescription-bottle-alt'
                ],
            ],
        ],

        // Almacén
        [
            'text'    => 'Almacén',
            'icon'    => 'fas fa-fw fa-warehouse',
            'can'     => ['ver inventario'],
            'submenu' => [
                [
                    'text' => 'Inventario',
                    'url'  => '/almacen',
                    'icon' => 'fas fa-fw fa-boxes'
                ],
                [
                    'text' => 'Nuevo Item',
                    'url'  => '/almacen/create',
                    'icon' => 'fas fa-fw fa-plus',
                    'can'  => 'crear items'
                ],
            ],
        ],

        // Despacho
        [
            'text'    => 'Despacho',
            'icon'    => 'fas fa-fw fa-truck',
            'can'     => ['ver despachos'],
            'submenu' => [
                [
                    'text' => 'Lista de Despachos',
                    'url'  => '/despacho',
                    'icon' => 'fas fa-fw fa-list'
                ],
                [
                    'text' => 'Nuevo Despacho',
                    'url'  => '/despacho/create',
                    'icon' => 'fas fa-fw fa-plus',
                    'can'  => 'crear despachos'
                ],
            ],
        ],

        // Administración
        [
            'header' => 'ADMINISTRACIÓN',
            'can'    => ['ver usuarios', 'gestionar roles'],
        ],
        [
            'text'    => 'Usuarios',
            'icon'    => 'fas fa-fw fa-users',
            'can'     => 'ver usuarios',
            'submenu' => [
                [
                    'text' => 'Lista de Usuarios',
                    'url'  => '/admin/users',
                    'icon' => 'fas fa-fw fa-list'
                ],
                [
                    'text' => 'Nuevo Usuario',
                    'url'  => '/admin/users/create',
                    'icon' => 'fas fa-fw fa-user-plus',
                    'can'  => 'crear usuarios'
                ],
            ],
        ],
        [
            'text'    => 'Roles y Permisos',
            'icon'    => 'fas fa-fw fa-user-shield',
            'can'     => 'gestionar roles',
            'submenu' => [
                [
                    'text' => 'Roles',
                    'url'  => '/admin/roles',
                    'icon' => 'fas fa-fw fa-user-tag'
                ],
                [
                    'text' => 'Permisos',
                    'url'  => '/admin/permissions',
                    'icon' => 'fas fa-fw fa-key'
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    */

    'plugins' => [
        'Moment' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/es.js',
                ],
            ],
        ],
        'FullCalendar' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales-all.min.js',
                ],
            ],
        ],
        'CustomFiles' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'css/admin_custom.css',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'js/admin_custom.js',
                ],
            ],
        ],
        'Datatables' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
                ],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
    ],
];

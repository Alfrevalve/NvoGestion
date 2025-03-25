<!DOCTYPE html>
<html lang="es" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistema integral para la gestión de procedimientos quirúrgicos">
    <meta name="author" content="Hospital System">
    <meta name="theme-color" content="#0F3061">
    <title>@yield('title', 'Sistema de Gestión de Cirugías')</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/icon-192.png') }}">

    <!-- Preconectar a CDNs para mejorar rendimiento -->
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- Font Awesome 6.4 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer">

    <!-- Estilos personalizados -->
    <style>
        :root {
            --primary-color: #0F3061;
            --primary-color-light: #1a4785;
            --primary-color-dark: #092348;
            --secondary-color: #0097CD;
            --secondary-color-light: #28b0e3;
            --accent-color: #FFC107;
            --success-color: #28a745;
            --danger-color: #dc3545;
            --warning-color: #ffc107;
            --info-color: #17a2b8;

            --bg-light: #f8f9fa;
            --bg-dark: #343a40;
            --text-dark: #212529;
            --text-light: #f8f9fa;
            --text-muted: #6c757d;

            --border-radius: 0.5rem;
            --box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            --transition-speed: 0.3s;
        }

        [data-bs-theme="dark"] {
            --bg-light: #343a40;
            --bg-dark: #212529;
            --text-dark: #f8f9fa;
            --text-light: #f8f9fa;
            --text-muted: #adb5bd;
        }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background-color: var(--bg-light);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: background-color var(--transition-speed);
        }

        .navbar {
            background-color: var(--primary-color);
            box-shadow: 0 2px 8px rgba(0,0,0,.15);
            padding: 0.75rem 1rem;
        }

        .navbar-brand {
            color: white !important;
            font-weight: 600;
            font-size: 1.25rem;
        }

        .nav-link {
            color: rgba(255,255,255,.85) !important;
            padding: 0.75rem 1rem;
            border-radius: var(--border-radius);
            transition: all var(--transition-speed);
        }

        .nav-link:hover {
            color: white !important;
            background-color: var(--primary-color-light);
        }

        .nav-link.active {
            color: white !important;
            font-weight: 500;
            background-color: var(--primary-color-light);
        }

        .card {
            box-shadow: var(--box-shadow);
            border: none;
            border-radius: var(--border-radius);
            margin-bottom: 1.5rem;
            transition: transform 0.2s, box-shadow 0.2s;
            overflow: hidden;
        }

        .card:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .card-header {
            background-color: rgba(0,0,0,.03);
            border-bottom: 1px solid rgba(0,0,0,.125);
            padding: 1rem 1.25rem;
            font-weight: 500;
        }

        .btn {
            border-radius: var(--border-radius);
            padding: 0.5rem 1rem;
            font-weight: 500;
            transition: all var(--transition-speed);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover, .btn-primary:focus {
            background-color: var(--primary-color-light);
            border-color: var(--primary-color-light);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        .btn-secondary:hover, .btn-secondary:focus {
            background-color: var(--secondary-color-light);
            border-color: var(--secondary-color-light);
            transform: translateY(-2px);
        }

        .text-primary {
            color: var(--primary-color) !important;
        }

        .alert {
            border: none;
            border-radius: var(--border-radius);
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
            box-shadow: var(--box-shadow);
        }

        .table {
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--box-shadow);
        }

        .table th {
            background-color: rgba(0,0,0,.03);
            border-top: none;
            padding: 0.75rem 1rem;
            font-weight: 600;
        }

        .table td {
            padding: 0.75rem 1rem;
            vertical-align: middle;
        }

        /* Badges estilizados */
        .badge {
            padding: 0.5em 0.75em;
            font-weight: 500;
            border-radius: 30px;
        }

        /* Estilos para el modo oscuro */
        .theme-toggle {
            cursor: pointer;
            color: rgba(255,255,255,.8);
            transition: all var(--transition-speed);
        }

        .theme-toggle:hover {
            color: white;
        }

        /* Animaciones y transiciones */
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .slide-in {
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from { transform: translateY(-10px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        /* Mejoras responsive */
        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 1.1rem;
            }

            .container-fluid {
                padding-left: 1rem;
                padding-right: 1rem;
            }
        }

        /* Skeleton loading */
        .skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
            border-radius: var(--border-radius);
            height: 1.2rem;
            margin-bottom: 0.5rem;
        }

        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }

        /* Footer */
        footer {
            background-color: var(--primary-color-dark);
            color: var(--text-light);
            padding: 1.5rem 0;
            margin-top: auto;
        }

        /* Page transitions */
        .page-transition {
            animation: pageTransition 0.4s ease-out;
        }

        @keyframes pageTransition {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Mejora de accesibilidad */
        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border-width: 0;
        }

        /* Tooltips personalizados */
        .custom-tooltip {
            --bs-tooltip-bg: var(--primary-color);
            --bs-tooltip-color: white;
        }

        /* Mejoras a los formularios */
        .form-control, .form-select {
            border-radius: var(--border-radius);
            padding: 0.625rem 0.75rem;
            border-color: #ced4da;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(15, 48, 97, 0.25);
        }

        /* Estilos para notificaciones */
        .notification-badge {
            position: absolute;
            top: 0.25rem;
            right: 0.25rem;
            padding: 0.25rem 0.5rem;
            border-radius: 50%;
            font-size: 0.75rem;
            background-color: var(--danger-color);
            color: white;
        }

        /* Iconos de estado para cirugías */
        .status-icon {
            display: inline-flex;
            width: 1rem;
            height: 1rem;
            border-radius: 50%;
            margin-right: 0.5rem;
        }

        .status-pendiente {
            background-color: var(--warning-color);
        }

        .status-en-curso {
            background-color: var(--info-color);
        }

        .status-completada {
            background-color: var(--success-color);
        }

        .status-cancelada {
            background-color: var(--danger-color);
        }

        /* Estados con animación */
        .status-en-curso {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { opacity: 0.6; }
            50% { opacity: 1; }
            100% { opacity: 0.6; }
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Barra de accesibilidad -->
    <div class="bg-dark text-white py-1 d-none d-lg-block">
        <div class="container-fluid">
            <div class="d-flex justify-content-end">
                <button class="btn btn-sm btn-link text-white me-2" onclick="increaseFontSize()">
                    <i class="fas fa-text-height" aria-hidden="true"></i> Aumentar texto
                </button>
                <button class="btn btn-sm btn-link text-white me-2" onclick="decreaseFontSize()">
                    <i class="fas fa-text-height fa-flip-vertical" aria-hidden="true"></i> Reducir texto
                </button>
                <button class="btn btn-sm btn-link text-white me-2 theme-toggle" id="theme-toggle">
                    <i class="fas fa-moon" aria-hidden="true"></i> <span id="theme-text">Modo oscuro</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Barra de navegación principal -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('cirugias.index') }}">
                <i class="fas fa-hospital-user me-2"></i>
                <span>Gestión de Cirugías</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
    <a class="nav-link {{ request()->routeIs('modulo.cirugias.index') ? 'active' : '' }}"
       href="{{ route('modulo.cirugias.index') }}">
        <i class="fas fa-procedures me-1" aria-hidden="true"></i> Cirugías
    </a>
        <i class="fas fa-procedures me-1" aria-hidden="true"></i> Cirugías
    </a>
                        <a class="nav-link {{ request()->routeIs('cirugias.dashboard') ? 'active' : '' }}"
                           href="{{ route('cirugias.dashboard') }}" aria-current="{{ request()->routeIs('cirugias.dashboard') ? 'page' : 'false' }}">
                            <i class="fas fa-tachometer-alt me-1" aria-hidden="true"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
    <a class="nav-link {{ request()->routeIs('modulo.cirugias.calendario') ? 'active' : '' }}"
       href="{{ route('modulo.cirugias.calendario') }}">
        <i class="fas fa-calendar-alt me-1" aria-hidden="true"></i> Calendario
    </a>
        <i class="fas fa-calendar-alt me-1" aria-hidden="true"></i> Calendario
    </a>
                        <a class="nav-link {{ request()->routeIs('cirugias.kanban') ? 'active' : '' }}"
                           href="{{ route('cirugias.kanban') }}" aria-current="{{ request()->routeIs('cirugias.kanban') ? 'page' : 'false' }}">
                            <i class="fas fa-columns me-1" aria-hidden="true"></i> Kanban
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('cirugias.calendario') ? 'active' : '' }}"
                           href="{{ route('cirugias.calendario') }}" aria-current="{{ request()->routeIs('cirugias.calendario') ? 'page' : 'false' }}">
                            <i class="fas fa-calendar-alt me-1" aria-hidden="true"></i> Calendario
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('cirugias.instituciones.*') || request()->routeIs('cirugias.medicos.*') || request()->routeIs('cirugias.instrumentistas.*') ? 'active' : '' }}" href="#" id="personalDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-users me-1" aria-hidden="true"></i> Personal
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="personalDropdown">
                            <li>
                                <a class="dropdown-item {{ request()->routeIs('cirugias.instituciones.*') ? 'active' : '' }}" href="{{ route('cirugias.instituciones.index') }}">
                                    <i class="fas fa-hospital me-1" aria-hidden="true"></i> Instituciones
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ request()->routeIs('cirugias.medicos.*') ? 'active' : '' }}" href="{{ route('cirugias.medicos.index') }}">
                                    <i class="fas fa-user-md me-1" aria-hidden="true"></i> Médicos
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ request()->routeIs('cirugias.instrumentistas.*') ? 'active' : '' }}" href="{{ route('cirugias.instrumentistas.index') }}">
                                    <i class="fas fa-user-nurse me-1" aria-hidden="true"></i> Instrumentistas
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('cirugias.equipos.*') || request()->routeIs('cirugias.materiales.*') ? 'active' : '' }}" href="#" id="recursosDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-box-open me-1" aria-hidden="true"></i> Recursos
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="recursosDropdown">
                            <li>
                                <a class="dropdown-item {{ request()->routeIs('cirugias.equipos.*') ? 'active' : '' }}" href="{{ route('cirugias.equipos.index') }}">
                                    <i class="fas fa-tools me-1" aria-hidden="true"></i> Equipos
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ request()->routeIs('cirugias.materiales.*') ? 'active' : '' }}" href="{{ route('cirugias.materiales.index') }}">
                                    <i class="fas fa-box me-1" aria-hidden="true"></i> Materiales
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('cirugias.reportes.*') ? 'active' : '' }}"
                           href="{{ route('cirugias.reportes.index') }}" aria-current="{{ request()->routeIs('cirugias.reportes.*') ? 'page' : 'false' }}">
                            <i class="fas fa-chart-bar me-1" aria-hidden="true"></i> Reportes
                        </a>
                    </li>
                </ul>

                <!-- Barra de búsqueda -->
                <form class="d-flex me-2" action="{{ route('cirugias.buscar') }}" method="GET">
                    <div class="input-group">
                        <input class="form-control" type="search" name="query" placeholder="Buscar cirugía..." aria-label="Buscar">
                        <button class="btn btn-light" type="submit">
                            <i class="fas fa-search" aria-hidden="true"></i>
                            <span class="sr-only">Buscar</span>
                        </button>
                    </div>
                </form>

                <!-- Menú de usuario -->
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="position-relative me-2">
                            <i class="fas fa-bell" aria-hidden="true"></i>
                            <span class="notification-badge">3</span>
                        </div>
                        <img src="{{ auth()->user()->avatar ?? asset('images/avatar-default.png') }}" alt="Avatar" class="rounded-circle me-1" width="32" height="32">
                        <span class="d-none d-md-inline">{{ auth()->user()->name ?? 'Usuario' }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><h6 class="dropdown-header">Notificaciones recientes</h6></li>
                        <li><a class="dropdown-item" href="#">Nueva cirugía programada</a></li>
                        <li><a class="dropdown-item" href="#">Cambio de estado: Cirugía #2548</a></li>
                        <li><a class="dropdown-item" href="#">Stock bajo: Materiales</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('cirugias.perfil') }}"><i class="fas fa-user-circle me-1" aria-hidden="true"></i> Mi Perfil</a></li>
                        <li><a class="dropdown-item" href="{{ route('cirugias.configuracion') }}"><i class="fas fa-cog me-1" aria-hidden="true"></i> Configuración</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fas fa-sign-out-alt me-1" aria-hidden="true"></i> Cerrar sesión
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Contenido principal -->
    <main class="container-fluid py-4 page-transition">
        <!-- Breadcrumbs -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('cirugias.index') }}">Inicio</a></li>
                @yield('breadcrumbs')
                <li class="breadcrumb-item active" aria-current="page">@yield('title', 'Dashboard')</li>
            </ol>
        </nav>

        <!-- Alertas y mensajes -->
        <div id="alertContainer">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show slide-in" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-check-circle me-2 fa-lg" aria-hidden="true"></i>
                        <div>
                            <strong>¡Éxito!</strong> {{ session('success') }}
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show slide-in" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-circle me-2 fa-lg" aria-hidden="true"></i>
                        <div>
                            <strong>Error:</strong> {{ session('error') }}
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            @endif

            @if(session('info'))
                <div class="alert alert-info alert-dismissible fade show slide-in" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-info-circle me-2 fa-lg" aria-hidden="true"></i>
                        <div>
                            <strong>Información:</strong> {{ session('info') }}
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            @endif

            @if(session('warning'))
                <div class="alert alert-warning alert-dismissible fade show slide-in" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle me-2 fa-lg" aria-hidden="true"></i>
                        <div>
                            <strong>Advertencia:</strong> {{ session('warning') }}
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show slide-in" role="alert">
                    <div class="d-flex">
                        <i class="fas fa-exclamation-triangle me-2 fa-lg align-self-start pt-1" aria-hidden="true"></i>
                        <div>
                            <strong>Por favor corrija los siguientes errores:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            @endif
        </div>

        <!-- Contenido específico de la página -->
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="mt-auto">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0">&copy; {{ date('Y') }} Sistema de Gestión de Cirugías - Todos los derechos reservados</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">
                        <a href="{{ route('cirugias.soporte') }}" class="text-white text-decoration-none">Soporte</a> |
                        <a href="{{ route('cirugias.ayuda') }}" class="text-white text-decoration-none">Ayuda</a> |
                        <a href="{{ route('cirugias.privacidad') }}" class="text-white text-decoration-none">Privacidad</a>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Loader overlay -->
    <div id="loader" class="position-fixed top-0 start-0 w-100 h-100 bg-white bg-opacity-75 d-flex justify-content-center align-items-center" style="display: none !important; z-index: 9999;">
        <div class="text-center">
            <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                <span class="visually-hidden">Cargando...</span>
            </div>
            <p class="mt-2">Cargando, por favor espere...</p>
        </div>
    </div>

    <!-- Toast para notificaciones -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">Sistema de Cirugías</strong>
                <small>Ahora</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Cerrar"></button>
            </div>
            <div class="toast-body">
                <!-- El contenido se insertará dinámicamente -->
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <!-- Bootstrap 5.3 Bundle con Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <!-- Scripts personalizados -->
    <script>
        // Funciones de utilidad y mejora de la experiencia de usuario
        document.addEventListener('DOMContentLoaded', function() {
            // Inicializar tooltips
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => {
                return new bootstrap.Tooltip(tooltipTriggerEl, {
                    customClass: 'custom-tooltip'
                });
            });

            // Inicializar popovers
            const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
            const popoverList = [...popoverTriggerList].map(popoverTriggerEl => {
                return new bootstrap.Popover(popoverTriggerEl);
            });

            // Cerrar alertas después de un tiempo
            setTimeout(function() {
                document.querySelectorAll('.alert:not(.alert-danger)').forEach(function(alert) {
                    const bsAlert = bootstrap.Alert.getInstance(alert);
                    if (bsAlert) {
                        bsAlert.close();
                    } else {
                        alert.classList.remove('show');
                        setTimeout(() => alert.remove(), 150);
                    }
                });
            }, 8000);

            // Cambiar tema claro/oscuro
            const themeToggle = document.getElementById('theme-toggle');
            const themeText = document.getElementById('theme-text');
            const iconElement = themeToggle.querySelector('i');

            // Detectar tema preferido del sistema
            const prefersDarkScheme = window.matchMedia('(prefers-color-scheme: dark)');

            // Verificar si hay una preferencia guardada
            let currentTheme = localStorage.getItem('theme');
            if (!currentTheme) {
                currentTheme = prefersDarkScheme.matches ? 'dark' : 'light';
            }

            // Aplicar tema al cargar la página
            if (currentTheme === 'dark') {
                document.documentElement.setAttribute('data-bs-theme', 'dark');
                iconElement.classList.remove('fa-moon');
                iconElement.classList.add('fa-sun');
                themeText.textContent = 'Modo claro';
            }

            // Manejar cambio de tema
            themeToggle.addEventListener('click', function() {
                let theme;
                if (document.documentElement.getAttribute('data-bs-theme') === 'dark') {
                    document.documentElement.setAttribute('data-bs-theme', 'light');
                    theme = 'light';
                    iconElement.classList.remove('fa-sun');
                    iconElement.classList.add('fa-moon');
                    themeText.textContent = 'Modo oscuro';
                } else {
                    document.documentElement.setAttribute('data-bs-theme', 'dark');
                    theme = 'dark';
                    iconElement.classList.remove('fa-moon');
                    iconElement.classList.add('fa-sun');
                    themeText.textContent = 'Modo claro';
                }
                localStorage.setItem('theme', theme);
            });
        });

        // Funciones para ajustar el tamaño de la fuente (accesibilidad)
        function increaseFontSize() {
            const root = document.documentElement;
            let fontSize = parseFloat(getComputedStyle(root).fontSize);
            root.style.fontSize = (fontSize + 1) + 'px';
            showToast('Tamaño de texto aumentado');
        }

        function decreaseFontSize() {
            const root = document.documentElement;
            let fontSize = parseFloat(getComputedStyle(root).fontSize);
            if (fontSize > 12) { // Evitar que la fuente sea demasiado pequeña
                root.style.fontSize = (fontSize - 1) + 'px';
                showToast('Tamaño de texto reducido');
            }
        }

        // Función para mostrar notificaciones toast
        function showToast(message, type = 'info') {
            const toastEl = document.getElementById('liveToast');
            const toastBody = toastEl.querySelector('.toast-body');

            // Establecer el mensaje y la clase de estilo
            toastBody.textContent = message;
            toastEl.className = 'toast';

            // Añadir clase según el tipo
            if (type === 'success') {
                toastEl.classList.add('bg-success', 'text-white');
            } else if (type === 'error') {
                toastEl.classList.add('bg-danger', 'text-white');
            } else if (type === 'warning') {
                toastEl.classList.add('bg-warning');
            } else {
                toastEl.classList.add('bg-info', 'text-white');
            }

            // Mostrar el toast
            const toast = new bootstrap.Toast(toastEl);
            toast.show();
        }

        // Función para mostrar/ocultar el loader
        function toggleLoader(show = true) {
            const loader = document.getElementById('loader');
            if (show) {
                loader.style.display = 'flex';
            } else {
                loader.style.display = 'none';
            }
        }

        // Interceptar envíos de formularios para mostrar loader
        document.addEventListener('submit', function(e) {
            if (e.target.tagName === 'FORM' && !e.target.hasAttribute('data-no-loader')) {
                toggleLoader(true);
            }
        });

        // Interceptar cambios de página
        window.addEventListener('beforeunload', function() {
            // Solo mostrar el loader si no es una acción de usuario como cerrar pestaña
            if (document.activeElement &&
                document.activeElement.tagName === 'A' &&
                !document.activeElement.hasAttribute('data-no-loader')) {
                toggleLoader(true);
            }
        });
    </script>

    @stack('scripts')
</body>
</html>

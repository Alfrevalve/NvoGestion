<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'NvoGestion'))</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Google Fonts - Roboto -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #0F3061;
            --secondary-color: #0097CD;
            --accent-color: #65D7CA;
            --light-accent: #AAE9E2;
            --dark-bg: #1a1a1a;
            --light-bg: #f8f9fa;
            --sidebar-width: 250px;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: var(--light-bg);
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background-color: var(--primary-color);
            background-image: linear-gradient(180deg, var(--primary-color) 10%, #0a264d 100%);
            color: white;
            z-index: 1000;
            transition: all 0.3s;
            box-shadow: 3px 0px 10px rgba(0,0,0,0.1);
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 20px;
            background-color: rgba(0,0,0,0.1);
            text-align: center;
        }

        .sidebar-logo {
            max-width: 120px;
            margin-bottom: 10px;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.8);
            transition: all 0.2s;
            border-left: 4px solid transparent;
            padding: 10px 20px;
        }

        .nav-link:hover {
            color: white;
            background-color: rgba(255,255,255,0.1);
            border-left-color: var(--accent-color);
        }

        .nav-link.active {
            color: white;
            background-color: rgba(255,255,255,0.15);
            border-left-color: var(--accent-color);
        }

        .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        .sidebar-footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            padding: 15px;
            text-align: center;
            background-color: rgba(0,0,0,0.2);
            font-size: 0.8rem;
        }

        /* Main Content Styles */
        .content-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: all 0.3s;
        }

        .header {
            height: 60px;
            background-color: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.5rem;
            margin-bottom: 20px;
        }

        .main-content {
            padding: 0 1.5rem 1.5rem;
        }

        .content-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            padding: 20px;
            margin-bottom: 20px;
        }

        /* Dropdown Menu */
        .dropdown-menu {
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border-radius: 8px;
        }

        .dropdown-item {
            padding: 8px 20px;
        }

        .dropdown-item:hover {
            background-color: var(--light-accent);
        }

        /* Responsive Toggle */
        #sidebarToggle {
            background: transparent;
            border: none;
            color: var(--primary-color);
            font-size: 1.2rem;
        }

        @media (max-width: 768px) {
            .sidebar {
                margin-left: calc(-1 * var(--sidebar-width));
            }

            .sidebar.active {
                margin-left: 0;
            }

            .content-wrapper {
                margin-left: 0;
                width: 100%;
            }
        }

        /* Custom Button Styles */
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: #0a264d;
            border-color: #0a264d;
        }

        .btn-secondary {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        .btn-secondary:hover {
            background-color: #0082b4;
            border-color: #0082b4;
        }

        .btn-accent {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
            color: white;
        }

        .btn-accent:hover {
            background-color: #54c6b9;
            border-color: #54c6b9;
            color: white;
        }

        /* Custom Card Styles */
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            margin-bottom: 20px;
        }

        .card-header {
            background-color: white;
            border-bottom: 1px solid #f0f0f0;
            padding: 15px 20px;
            font-weight: 500;
            border-radius: 10px 10px 0 0 !important;
        }

        .card-body {
            padding: 20px;
        }

        /* Badge styles */
        .badge {
            padding: 6px 10px;
            font-weight: 500;
            border-radius: 6px;
        }

        /* Status Colors */
        .status-pendiente {
            background-color: var(--primary-color);
        }

        .status-programada {
            background-color: var(--secondary-color);
        }

        .status-en-proceso {
            background-color: var(--accent-color);
        }

        .status-finalizada {
            background-color: var(--light-accent);
            color: #333;
        }

        /* Alert styles */
        .alert {
            border-radius: 8px;
            border: none;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        /* Table styles */
        .table {
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
        }

        .table thead th {
            background-color: #f8f9fa;
            border-top: none;
            border-bottom: 1px solid #e9ecef;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
            color: #6c757d;
        }

        .table tbody tr:hover {
            background-color: rgba(245, 247, 250, 0.5);
        }

        .table td {
            vertical-align: middle;
            border-top: 1px solid #e9ecef;
        }

        /* Form styles */
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(15, 48, 97, 0.25);
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        /* Animations */
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>

    @yield('styles')
</head>
<body>
    <div class="wrapper" id="wrapper">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <h4 class="mb-0">NvoGestion</h4>
            </div>

            <hr class="my-0 bg-light opacity-25">

            <div class="p-2">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                   href="{{ route('dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i> Dashboard
                </a>

                <div class="text-white-50 small text-uppercase px-3 mt-4 mb-1">Módulos</div>

                <a class="nav-link {{ request()->routeIs('modulo.cirugias.*') ? 'active' : '' }}"
                   href="{{ route('modulo.cirugias.index') }}">
                    <i class="fas fa-fw fa-procedures"></i> Cirugías
                </a>

                <a class="nav-link {{ request()->routeIs('modulo.cirugias.calendario') ? 'active' : '' }}"
                   href="{{ route('modulo.cirugias.calendario') }}">
                    <i class="fas fa-fw fa-calendar-alt"></i> Calendario
                </a>

                <a class="nav-link {{ request()->routeIs('modulo.almacen.*') ? 'active' : '' }}"
                   href="{{ route('modulo.almacen.index') }}">
                    <i class="fas fa-fw fa-warehouse"></i> Almacén
                </a>

                <a class="nav-link {{ request()->routeIs('modulo.despacho.*') ? 'active' : '' }}"
                   href="{{ route('modulo.despacho.index') }}">
                    <i class="fas fa-fw fa-truck"></i> Despacho
                </a>

                <div class="text-white-50 small text-uppercase px-3 mt-4 mb-1">Configuración</div>

                <a class="nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}"
                   href="{{ url('admin') }}">
                    <i class="fas fa-fw fa-cogs"></i> Administración
                </a>
            </div>

            <div class="sidebar-footer">
                <p class="mb-0">&copy; {{ date('Y') }} - NvoGestion</p>
            </div>
        </div>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Header -->
            <div class="header">
                <button class="btn" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>

                <div class="d-flex align-items-center">
                    @auth
                        <div class="dropdown">
                            <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->name }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> Perfil</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i> Configuración</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt me-2"></i> Cerrar sesión
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary">Iniciar sesión</a>
                    @endauth
                </div>
            </div>

            <!-- Main Content -->
            <div class="main-content">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery (needed for some plugins) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Custom Scripts -->
    <script>
        $(document).ready(function() {
            $('#sidebarToggle').on('click', function() {
                $('.sidebar').toggleClass('active');
            });

            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                $('.alert').alert('close');
            }, 5000);
        });
    </script>

    @yield('scripts')
</body>
</html>>

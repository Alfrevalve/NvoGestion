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

        /* Breadcrumb Styles */
        .breadcrumb {
            background-color: transparent;
            padding: 0.75rem 0;
            margin-bottom: 0;
        }
        .breadcrumb-item + .breadcrumb-item::before {
            content: "›";
            color: var(--primary-color);
        }
        .breadcrumb-item a {
            color: var(--primary-color);
            text-decoration: none;
        }
        .breadcrumb-item a:hover {
            color: var(--secondary-color);
            text-decoration: underline;
        }
        .breadcrumb-item.active {
            color: var(--secondary-color);
        }

        .sidebar-header {
            padding: 20px;
            background-color: rgba(0,0,0,0.1);
            text-align: center;
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

        /* Responsive styles */
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

                <a class="nav-link {{ request()->routeIs('cirugias.*') ? 'active' : '' }}"
                   href="{{ route('cirugias.index') }}">
                    <i class="fas fa-fw fa-procedures"></i> Cirugías
                </a>

                <a class="nav-link {{ request()->routeIs('cirugias.calendario') ? 'active' : '' }}"
                   href="{{ route('cirugias.calendario') }}">
                    <i class="fas fa-fw fa-calendar-alt"></i> Calendario
                </a>

                <a class="nav-link {{ request()->routeIs('almacen.*') ? 'active' : '' }}"
                   href="{{ url('almacen') }}">
                    <i class="fas fa-fw fa-warehouse"></i> Almacén
                </a>

                <a class="nav-link {{ request()->routeIs('despacho.*') ? 'active' : '' }}"
                   href="{{ url('despacho') }}">
                    <i class="fas fa-fw fa-truck"></i> Despacho
                </a>

                <div class="text-white-50 small text-uppercase px-3 mt-4 mb-1">Configuración</div>

                <a class="nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}"
                   href="{{ url('admin') }}">
                    <i class="fas fa-fw fa-cogs"></i> Administración
                </a>
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
                                <li><a class="dropdown-item" href="{{ route('admin.profile') }}">
                                    <i class="fas fa-user me-2"></i> Perfil</a>
                                </li>
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
                <!-- Breadcrumbs -->
                @if(!request()->routeIs('dashboard'))
                    <div class="mb-3">
                        <div class="breadcrumb-wrapper">
                            @try
                                {!! Breadcrumbs::render() !!}
                            @catch (\Exception $e)
                                {{-- Silently fail if breadcrumbs error --}}
                            @endtry
                        </div>
                    </div>
                @endif

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
</html>

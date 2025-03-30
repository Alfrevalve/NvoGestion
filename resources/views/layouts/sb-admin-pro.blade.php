<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'GesVitalPro'))</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />
    
    <!-- Google Fonts - Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome Free 5.15.4 -->
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
    
    <!-- SB Admin Pro Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/sb-admin-pro.css') }}">
    
    <!-- Custom Styles -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    
    @yield('styles')
</head>
<body class="nav-fixed">
    <!-- Top Navigation -->
    @include('layouts.topnav-pro')
    
    <!-- Main Content Layout -->
    <div id="layoutSidenav">
        <!-- Sidebar Navigation -->
        <div id="layoutSidenav_nav">
            @include('layouts.sidebar-pro')
        </div>
        
        <!-- Page Content -->
        <div id="layoutSidenav_content">
            <main>
                <!-- Page Header -->
                <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
                    <div class="container-xl px-4">
                        <div class="page-header-content pt-4">
                            <div class="row align-items-center justify-content-between">
                                <div class="col-auto mt-4">
                                    <h1 class="page-header-title">
                                        <div class="page-header-icon">
                                            @yield('header-icon', '<i class="fas fa-tachometer-alt"></i>')
                                        </div>
                                        @yield('header-title', 'Dashboard')
                                    </h1>
                                    <div class="page-header-subtitle">@yield('header-subtitle', '')</div>
                                </div>
                                <div class="col-12 col-xl-auto mt-4">
                                    @yield('header-actions')
                                </div>
                            </div>
                        </div>
                    </div>
                </header>
                
                <!-- Page Content -->
                <div class="container-xl px-4 mt-n10">
                    <!-- Alerts -->
                    @if(session('success'))
                        <div class="alert alert-success alert-icon" role="alert">
                            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-icon-aside">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="alert-icon-content">
                                <h6 class="alert-heading">¡Éxito!</h6>
                                {{ session('success') }}
                            </div>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-icon" role="alert">
                            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-icon-aside">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <div class="alert-icon-content">
                                <h6 class="alert-heading">¡Error!</h6>
                                {{ session('error') }}
                            </div>
                        </div>
                    @endif

                    @if(session('warning'))
                        <div class="alert alert-warning alert-icon" role="alert">
                            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-icon-aside">
                                <i class="fas fa-exclamation-circle"></i>
                            </div>
                            <div class="alert-icon-content">
                                <h6 class="alert-heading">¡Atención!</h6>
                                {{ session('warning') }}
                            </div>
                        </div>
                    @endif

                    @if(session('info'))
                        <div class="alert alert-info alert-icon" role="alert">
                            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-icon-aside">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            <div class="alert-icon-content">
                                <h6 class="alert-heading">Información</h6>
                                {{ session('info') }}
                            </div>
                        </div>
                    @endif
                    
                    @yield('content')
                </div>
            </main>
            
            <!-- Footer -->
            @include('layouts.footer-pro')
        </div>
    </div>
    
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- SB Admin Pro Scripts -->
    <script src="{{ asset('js/sb-admin-pro.js') }}"></script>
    
    <!-- Page-specific scripts -->
    @yield('scripts')
    
    <script>
        $(document).ready(function() {
            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                $('.alert').alert('close');
            }, 5000);
            
            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
        });
    </script>
</body>
</html>
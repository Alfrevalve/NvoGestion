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
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">

    @yield('styles')
</head>
<body>
    <div class="wrapper" id="wrapper">
        <!-- Sidebar -->        
        @include('layouts.sidebar')

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Header -->
            @include('layouts.navbar')

            <!-- Main Content -->
            <!-- Main Content -->
            <div class="main-content">
                <!-- Mobile Breadcrumbs (only visible on mobile) -->
                @if(!request()->routeIs('dashboard'))
                    <div class="mb-3 d-md-none">
                        <div class="breadcrumb-wrapper">
                            @try
                                {!! Breadcrumbs::render() !!}
                            @catch (\Exception $e)
                                <h5 class="mb-0 text-primary">{{ request()->segment(1) ? ucfirst(request()->segment(1)) : 'Dashboard' }}</h5>
                            @endtry
                        </div>
                    </div>
                @endif

                <!-- Alerts -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center shadow-sm" role="alert">
                        <div class="me-3">
                            <i class="fas fa-check-circle fa-lg"></i>
                        </div>
                        <div>
                            <strong>¡Éxito!</strong> {{ session('success') }}
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center shadow-sm" role="alert">
                        <div class="me-3">
                            <i class="fas fa-exclamation-circle fa-lg"></i>
                        </div>
                        <div>
                            <strong>¡Error!</strong> {{ session('error') }}
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('warning'))
                    <div class="alert alert-warning alert-dismissible fade show d-flex align-items-center shadow-sm" role="alert">
                        <div class="me-3">
                            <i class="fas fa-exclamation-triangle fa-lg"></i>
                        </div>
                        <div>
                            <strong>¡Atención!</strong> {{ session('warning') }}
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('info'))
                    <div class="alert alert-info alert-dismissible fade show d-flex align-items-center shadow-sm" role="alert">
                        <div class="me-3">
                            <i class="fas fa-info-circle fa-lg"></i>
                        </div>
                        <div>
                            <strong>Información:</strong> {{ session('info') }}
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    @include('layouts.footer')


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery (needed for some plugins) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Custom Scripts -->
    <!-- Custom Scripts -->
    <script src="{{ asset('js/sidebar.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Sidebar toggle is now handled by sidebar.js

            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                $('.alert').alert('close');
            }, 5000);
            
            // Add fade animation to dropdown menus
            $('.dropdown').on('show.bs.dropdown', function() {
                $(this).find('.dropdown-menu').first().stop(true, true).fadeIn(200);
            });
            $('.dropdown').on('hide.bs.dropdown', function() {
                $(this).find('.dropdown-menu').first().stop(true, true).fadeOut(200);
            });
            
            // Add loading state to buttons when clicked
            $('button[type="submit"]').on('click', function() {
                var $btn = $(this);
                if (!$btn.hasClass('no-loading')) {
                    $btn.addClass('btn-loading');
                    setTimeout(function() {
                        if ($btn.hasClass('btn-loading')) {
                            $btn.removeClass('btn-loading');
                        }
                    }, 10000); // Safety timeout to remove loading state if form submission takes too long
                }
            });
            
            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
            
            // Highlight active menu item based on URL
            var url = window.location.href;
            $('.nav-link').each(function() {
                if (this.href === url) {
                    $(this).addClass('active');
                    $(this).closest('.nav-section').find('.nav-section-title').addClass('active');
                }
            });
        });
    </script>

    @yield('scripts')
</body>
</html>

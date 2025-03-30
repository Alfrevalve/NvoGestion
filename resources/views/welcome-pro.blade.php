<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'GesVitalPro') }} - Sistema de Gestión Médica</title>
    
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
    
    <style>
        .bg-gradient-primary-to-secondary {
            background: linear-gradient(135deg, #0061f2 0%, #6900c7 100%);
        }
        .feature-box {
            transition: all 0.3s ease;
        }
        .feature-box:hover {
            transform: translateY(-10px);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container px-5">
            <a class="navbar-brand" href="{{ url('/') }}">
                <span class="fw-bold">GesVitalPro</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Características</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">Nosotros</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contacto</a>
                    </li>
                    @if (Route::has('login'))
                        @auth
                            <li class="nav-item">
                                <a href="{{ url('/dashboard') }}" class="nav-link">Dashboard</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a href="{{ route('login') }}" class="nav-link">Iniciar Sesión</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a href="{{ route('register') }}" class="btn btn-outline-light ms-3">Registrarse</a>
                                </li>
                            @endif
                        @endauth
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Header -->
    <header class="bg-gradient-primary-to-secondary py-5">
        <div class="container px-5">
            <div class="row gx-5 align-items-center justify-content-center">
                <div class="col-lg-8 col-xl-7 col-xxl-6">
                    <div class="my-5 text-center text-xl-start text-white">
                        <h1 class="display-5 fw-bold mb-2">Sistema de Gestión Médica</h1>
                        <p class="lead fw-normal mb-4">Una plataforma completa para la gestión de cirugías, equipos médicos, instrumentistas y más.</p>
                        <div class="d-grid gap-3 d-sm-flex justify-content-sm-center justify-content-xl-start">
                            <a class="btn btn-white btn-lg px-4 me-sm-3" href="{{ route('login') }}">Comenzar</a>
                            <a class="btn btn-outline-light btn-lg px-4" href="#features">Saber más</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-5 col-xxl-6 d-none d-xl-block text-center">
                    <img class="img-fluid rounded-3 my-5" src="https://source.unsplash.com/random/600x400/?medical" alt="Medical Dashboard" />
                </div>
            </div>
        </div>
    </header>
    
    <!-- Features Section -->
    <section class="py-5" id="features">
        <div class="container px-5 my-5">
            <div class="row gx-5">
                <div class="col-lg-4 mb-5 mb-lg-0">
                    <h2 class="fw-bold mb-0">Un sistema completo para gestionar su práctica médica.</h2>
                </div>
                <div class="col-lg-8">
                    <div class="row gx-5 row-cols-1 row-cols-md-2">
                        <div class="col mb-5 h-100">
                            <div class="feature-box bg-light p-4 rounded-3 shadow-sm">
                                <div class="mb-3">
                                    <i class="fas fa-procedures fa-2x text-primary"></i>
                                </div>
                                <h2 class="h5">Gestión de Cirugías</h2>
                                <p class="mb-0">Programe, organice y realice seguimiento de todas sus cirugías en un solo lugar.</p>
                            </div>
                        </div>
                        <div class="col mb-5 h-100">
                            <div class="feature-box bg-light p-4 rounded-3 shadow-sm">
                                <div class="mb-3">
                                    <i class="fas fa-calendar-alt fa-2x text-primary"></i>
                                </div>
                                <h2 class="h5">Calendario Integrado</h2>
                                <p class="mb-0">Visualice todas sus operaciones programadas en un calendario intuitivo.</p>
                            </div>
                        </div>
                        <div class="col mb-5 mb-md-0 h-100">
                            <div class="feature-box bg-light p-4 rounded-3 shadow-sm">
                                <div class="mb-3">
                                    <i class="fas fa-boxes fa-2x text-primary"></i>
                                </div>
                                <h2 class="h5">Control de Inventario</h2>
                                <p class="mb-0">Gestione su inventario médico con alertas de stock bajo y seguimiento de equipos.</p>
                            </div>
                        </div>
                        <div class="col h-100">
                            <div class="feature-box bg-light p-4 rounded-3 shadow-sm">
                                <div class="mb-3">
                                    <i class="fas fa-truck fa-2x text-primary"></i>
                                </div>
                                <h2 class="h5">Despachos</h2>
                                <p class="mb-0">Controle los despachos de equipos e insumos médicos a diferentes instituciones.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- About Section -->
    <section class="py-5 bg-light" id="about">
        <div class="container px-5 my-5">
            <div class="row gx-5 align-items-center">
                <div class="col-lg-6">
                    <img class="img-fluid rounded mb-5 mb-lg-0" src="https://source.unsplash.com/random/600x400/?hospital" alt="Medical Team" />
                </div>
                <div class="col-lg-6">
                    <h2 class="fw-bold">Sobre GesVitalPro</h2>
                    <p class="lead fw-normal text-muted mb-0">GesVitalPro es un sistema integral diseñado para optimizar la gestión de prácticas médicas, cirugías y equipamiento. Nuestra plataforma permite a los profesionales de la salud centrarse en lo más importante: sus pacientes.</p>
                    <div class="mt-4">
                        <a href="#contact" class="btn btn-primary">Contáctenos</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Contact Section -->
    <section class="py-5" id="contact">
        <div class="container px-5 my-5">
            <div class="row gx-5 justify-content-center">
                <div class="col-lg-8 col-xl-6">
                    <div class="text-center">
                        <h2 class="fw-bold">Contáctenos</h2>
                        <p class="lead fw-normal text-muted mb-5">¿Listo para comenzar? Envíenos un mensaje y nos pondremos en contacto con usted a la brevedad.</p>
                    </div>
                </div>
            </div>
            <div class="row gx-5 justify-content-center">
                <div class="col-lg-8 col-xl-6">
                    <form>
                        <div class="mb-3">
                            <input class="form-control" type="text" placeholder="Nombre completo" />
                        </div>
                        <div class="mb-3">
                            <input class="form-control" type="email" placeholder="Email" />
                        </div>
                        <div class="mb-3">
                            <input class="form-control" type="tel" placeholder="Teléfono" />
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control" rows="5" placeholder="Mensaje"></textarea>
                        </div>
                        <div class="d-grid">
                            <button class="btn btn-primary btn-lg" type="submit">Enviar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Footer -->
    <footer class="py-4 bg-dark">
        <div class="container px-5">
            <div class="row align-items-center justify-content-between flex-column flex-sm-row">
                <div class="col-auto">
                    <div class="small text-white">Copyright &copy; GesVitalPro {{ date('Y') }}</div>
                </div>
                <div class="col-auto">
                    <a class="link-light small" href="#!">Privacidad</a>
                    <span class="text-white mx-1">&middot;</span>
                    <a class="link-light small" href="#!">Términos</a>
                    <span class="text-white mx-1">&middot;</span>
                    <a class="link-light small" href="#!">Contacto</a>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- SB Admin Pro Scripts -->
    <script src="{{ asset('js/sb-admin-pro.js') }}"></script>
</body>
</html>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - {{ config('app.name', 'GesVitalPro') }}</title>
    
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
        .bg-login-image {
            background: url('https://source.unsplash.com/random/600x800/?medical');
            background-position: center;
            background-size: cover;
        }
    </style>
</head>
<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container-xl px-4">
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header justify-content-center">
                                    <h3 class="fw-light my-4">Iniciar Sesión</h3>
                                </div>
                                <div class="card-body">
                                    <!-- Session Status -->
                                    @if (session('status'))
                                        <div class="alert alert-success alert-icon" role="alert">
                                            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                                            <div class="alert-icon-aside">
                                                <i class="fas fa-check"></i>
                                            </div>
                                            <div class="alert-icon-content">
                                                {{ session('status') }}
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf
                                        
                                        <!-- Email Address -->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="email">Email</label>
                                            <input class="form-control @error('email') is-invalid @enderror" id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Ingrese su correo electrónico" required autofocus autocomplete="username" />
                                            @error('email')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        
                                        <!-- Password -->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="password">Contraseña</label>
                                            <input class="form-control @error('password') is-invalid @enderror" id="password" type="password" name="password" placeholder="Ingrese su contraseña" required autocomplete="current-password" />
                                            @error('password')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        
                                        <!-- Remember Me -->
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" id="remember_me" type="checkbox" name="remember" />
                                                <label class="form-check-label" for="remember_me">Recordarme</label>
                                            </div>
                                        </div>
                                        
                                        <!-- Login Button and Forgot Password -->
                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            @if (Route::has('password.request'))
                                                <a class="small" href="{{ route('password.request') }}">
                                                    ¿Olvidó su contraseña?
                                                </a>
                                            @endif
                                            <button class="btn btn-primary" type="submit">Iniciar Sesión</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small">
                                        @if (Route::has('register'))
                                            <a href="{{ route('register') }}">¿Necesita una cuenta? ¡Regístrese!</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="footer-admin mt-auto footer-dark">
                <div class="container-xl px-4">
                    <div class="row">
                        <div class="col-md-6 small">Copyright &copy; {{ config('app.name', 'GesVitalPro') }} {{ date('Y') }}</div>
                        <div class="col-md-6 text-md-end small">
                            <a href="#!">Política de Privacidad</a>
                            &middot;
                            <a href="#!">Términos &amp; Condiciones</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- SB Admin Pro Scripts -->
    <script src="{{ asset('js/sb-admin-pro.js') }}"></script>
</body>
</html>
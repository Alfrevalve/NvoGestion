<div class="header">
    <div class="d-flex align-items-center">
        <!-- Sidebar Toggle Button -->
        <button class="sidebar-toggle btn btn-sm rounded-circle me-3 shadow-sm d-flex align-items-center justify-content-center" aria-label="Toggle Sidebar">
            <i class="fas fa-bars"></i>
        </button>
        
        <!-- Breadcrumbs -->
        <div class="breadcrumb-wrapper d-none d-md-block">
            @try
                {!! Breadcrumbs::render() !!}
            @catch (\Exception $e)
                <h5 class="mb-0 text-primary fw-semibold">
                    {{ request()->segment(1) ? ucfirst(request()->segment(1)) : 'Dashboard' }}
                </h5>
            @endtry
        </div>
    </div>

    <div class="d-flex align-items-center">
        <!-- Search -->
        <div class="position-relative me-3 d-none d-md-block">
            <form action="{{ route('search') }}" method="GET" class="search-form">
                <div class="input-group input-group-sm">
                    <input type="text" class="form-control form-control-sm border-0 bg-light rounded-pill ps-3" 
                           placeholder="Buscar..." aria-label="Buscar" name="q" style="width: 180px;">
                    <button class="btn btn-sm bg-transparent border-0 position-absolute" type="submit" 
                            style="right: 0; top: 0; bottom: 0;">
                        <i class="fas fa-search text-muted"></i>
                    </button>
                </div>
            </form>
        </div>

        <!-- Notifications Dropdown -->
        <div class="dropdown me-3">
            <button class="btn btn-sm rounded-circle position-relative shadow-sm" type="button" 
                    data-bs-toggle="dropdown" aria-expanded="false" aria-label="Notificaciones">
                <i class="fas fa-bell"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    3
                </span>
            </button>
            <div class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-lg py-0" style="width: 320px;">
                <div class="dropdown-header bg-primary text-white py-2 px-3 rounded-top">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Notificaciones</h6>
                        <span class="badge bg-light text-primary">3 nuevas</span>
                    </div>
                </div>
                <div class="dropdown-body p-0" style="max-height: 300px; overflow-y: auto;">
                    <a href="#" class="dropdown-item d-flex align-items-center py-2 px-3 border-bottom">
                        <div class="flex-shrink-0 me-2">
                            <div class="avatar bg-light-primary rounded-circle p-1">
                                <i class="fas fa-calendar-check text-primary"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="mb-0 small">Nueva cirugía programada</p>
                            <small class="text-muted">Hace 5 minutos</small>
                        </div>
                    </a>
                    <a href="#" class="dropdown-item d-flex align-items-center py-2 px-3 border-bottom">
                        <div class="flex-shrink-0 me-2">
                            <div class="avatar bg-light-warning rounded-circle p-1">
                                <i class="fas fa-exclamation-triangle text-warning"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="mb-0 small">Stock bajo en Almacén</p>
                            <small class="text-muted">Hace 1 hora</small>
                        </div>
                    </a>
                    <a href="#" class="dropdown-item d-flex align-items-center py-2 px-3">
                        <div class="flex-shrink-0 me-2">
                            <div class="avatar bg-light-success rounded-circle p-1">
                                <i class="fas fa-truck text-success"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="mb-0 small">Despacho completado</p>
                            <small class="text-muted">Hace 2 horas</small>
                        </div>
                    </a>
                </div>
                <div class="dropdown-footer text-center py-2 border-top">
                    <a href="#" class="text-primary small">Ver todas las notificaciones</a>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions Dropdown -->
        <div class="dropdown me-3 d-none d-md-block">
            <button class="btn btn-sm rounded-circle shadow-sm" type="button" 
                    data-bs-toggle="dropdown" aria-expanded="false" aria-label="Acciones rápidas">
                <i class="fas fa-plus"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-lg py-0">
                <div class="dropdown-header bg-primary text-white py-2 px-3 rounded-top">
                    <h6 class="mb-0">Acciones rápidas</h6>
                </div>
                <div class="dropdown-body p-0">
                    <a href="{{ route('cirugias.create') }}" class="dropdown-item py-2 px-3">
                        <i class="fas fa-procedures me-2 text-primary"></i> Nueva cirugía
                    </a>
                    <a href="#" class="dropdown-item py-2 px-3">
                        <i class="fas fa-user-injured me-2 text-success"></i> Nuevo paciente
                    </a>
                    <a href="#" class="dropdown-item py-2 px-3">
                        <i class="fas fa-warehouse me-2 text-warning"></i> Nuevo item almacén
                    </a>
                    <a href="#" class="dropdown-item py-2 px-3">
                        <i class="fas fa-truck me-2 text-info"></i> Nuevo despacho
                    </a>
                </div>
            </div>
        </div>
        
        <!-- User Menu -->
        @auth
            <div class="dropdown">
                <button class="btn btn-sm rounded-pill dropdown-toggle d-flex align-items-center shadow-sm" 
                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="avatar bg-primary text-white rounded-circle me-2" 
                         style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-lg py-0">
                    <div class="dropdown-header bg-light py-2 px-3">
                        <p class="mb-0 text-dark fw-semibold">{{ Auth::user()->name }}</p>
                        <small class="text-muted">{{ Auth::user()->email }}</small>
                    </div>
                    <li><a class="dropdown-item py-2" href="{{ route('profile.edit') }}">
                        <i class="fas fa-user me-2 text-primary"></i> Mi Perfil</a>
                    </li>
                    <li><a class="dropdown-item py-2" href="#">
                        <i class="fas fa-cog me-2 text-secondary"></i> Configuración</a>
                    </li>
                    <li><hr class="dropdown-divider my-1"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item py-2 text-danger">
                                <i class="fas fa-sign-out-alt me-2"></i> Cerrar sesión
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        @else
            <a href="{{ route('login') }}" class="btn btn-primary btn-sm rounded-pill shadow-sm">
                <i class="fas fa-sign-in-alt me-2"></i> Iniciar sesión
            </a>
        @endauth
    </div>
</div>

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
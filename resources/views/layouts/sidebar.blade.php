<div class="sidebar">
    <!-- Sidebar Header -->
    <div class="sidebar-header">
        <img src="{{ asset('images/logo.png') }}" alt="GesVitalPro Logo" class="img-fluid" style="max-width: 150px;">
    </div>

    <!-- User Info -->
    <div class="sidebar-user">
        <div class="d-flex align-items-center px-4 py-3">
            <div class="user-avatar">
                <i class="fas fa-user-circle fa-2x text-white-50"></i>
            </div>
            <div class="user-info ml-3">
                <div class="font-weight-bold text-white">{{ Auth::user()->name ?? 'Usuario' }}</div>
                <div class="small text-white-50">{{ Auth::user()->email ?? 'usuario@ejemplo.com' }}</div>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <ul class="nav flex-column">
        <!-- Dashboard -->
        <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <!-- Cirugías Section -->
        <div class="sidebar-heading text-white-50 px-4 mt-4 mb-2">
            GESTIÓN MÉDICA
        </div>
        
        <li class="nav-item">
            <a href="{{ route('cirugias.index') }}" class="nav-link {{ request()->routeIs('cirugias.*') ? 'active' : '' }}">
                <i class="fas fa-procedures"></i>
                <span>Cirugías</span>
            </a>
        </li>
        
        <li class="nav-item">
            <a href="{{ route('cirugias.calendario') }}" class="nav-link {{ request()->routeIs('cirugias.calendario') ? 'active' : '' }}">
                <i class="fas fa-calendar-alt"></i>
                <span>Calendario</span>
            </a>
        </li>
        
        <!-- Pacientes (placeholder) -->
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fas fa-user-injured"></i>
                <span>Pacientes</span>
            </a>
        </li>
        
        <!-- Médicos (placeholder) -->
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fas fa-user-md"></i>
                <span>Médicos</span>
            </a>
        </li>
        
        <!-- Actividades (based on model) -->
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fas fa-clipboard-list"></i>
                <span>Actividades</span>
            </a>
        </li>

        <!-- Reportes Section -->
        <div class="sidebar-heading text-white-50 px-4 mt-4 mb-2">
            REPORTES
        </div>
        
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fas fa-chart-bar"></i>
                <span>Reportes de Cirugías</span>
            </a>
        </li>
        
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fas fa-chart-pie"></i>
                <span>Estadísticas</span>
            </a>
        </li>

        <!-- Admin Section -->
        <div class="sidebar-heading text-white-50 px-4 mt-4 mb-2">
            ADMINISTRACIÓN
        </div>
        
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fas fa-users"></i>
                <span>Usuarios</span>
            </a>
        </li>
        
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fas fa-user-shield"></i>
                <span>Roles</span>
            </a>
        </li>
        
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fas fa-cog"></i>
                <span>Configuración</span>
            </a>
        </li>

        <!-- User Section -->
        <div class="sidebar-heading text-white-50 px-4 mt-4 mb-2">
            CUENTA
        </div>
        
        <li class="nav-item">
            <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <i class="fas fa-user-cog"></i>
                <span>Mi Perfil</span>
            </a>
        </li>
        
        <li class="nav-item">
            <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i>
                <span>Cerrar Sesión</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>
    </ul>

    <!-- Sidebar Footer -->
    <div class="sidebar-footer">
        <div class="text-white-50 small px-4 py-3">
            <div>GesVitalPro v1.0</div>
            <div>© {{ date('Y') }} Todos los derechos reservados</div>
        </div>
    </div>
</div>
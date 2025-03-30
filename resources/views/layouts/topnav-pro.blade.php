<!-- Top Navigation -->
<nav class="topnav navbar navbar-expand shadow navbar-light bg-white" id="sidenavAccordion">
    <!-- Navbar Brand-->
    <a class="navbar-brand pe-3 ps-4 ps-lg-2" href="{{ route('dashboard') }}">
        <img src="{{ asset('images/logo.png') }}" alt="GesVitalPro Logo" style="height: 36px;">
    </a>
    
    <!-- Sidebar Toggle Button-->
    <button class="btn btn-icon btn-transparent-dark order-1 order-lg-0 me-2" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>
    
    <!-- Navbar Search Input-->
    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        <div class="input-group input-group-joined input-group-solid">
            <input class="form-control pe-0" type="text" placeholder="Buscar..." aria-label="Search" aria-describedby="basic-addon2" />
            <div class="input-group-text"><i class="fas fa-search"></i></div>
        </div>
    </form>
    
    <!-- Navbar Items-->
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
        <!-- Activity Center Dropdown-->
        <li class="nav-item dropdown no-caret d-none d-sm-block me-3 dropdown-notifications">
            <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownAlerts" href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <span class="position-absolute top-0 end-0 translate-middle badge rounded-pill bg-danger">3</span>
            </a>
            <div class="dropdown-menu dropdown-menu-end border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownAlerts">
                <h6 class="dropdown-header dropdown-notifications-header">
                    <i class="me-2 fas fa-bell"></i>
                    Centro de Notificaciones
                </h6>
                <!-- Notification Item 1-->
                <a class="dropdown-item dropdown-notifications-item" href="#!">
                    <div class="dropdown-notifications-item-icon bg-warning"><i class="fas fa-exclamation-triangle"></i></div>
                    <div class="dropdown-notifications-item-content">
                        <div class="dropdown-notifications-item-content-details">Hace 2 horas</div>
                        <div class="dropdown-notifications-item-content-text">Stock bajo en Almacén</div>
                    </div>
                </a>
                <!-- Notification Item 2-->
                <a class="dropdown-item dropdown-notifications-item" href="#!">
                    <div class="dropdown-notifications-item-icon bg-info"><i class="fas fa-calendar-check"></i></div>
                    <div class="dropdown-notifications-item-content">
                        <div class="dropdown-notifications-item-content-details">Hace 5 minutos</div>
                        <div class="dropdown-notifications-item-content-text">Nueva cirugía programada</div>
                    </div>
                </a>
                <!-- Notification Item 3-->
                <a class="dropdown-item dropdown-notifications-item" href="#!">
                    <div class="dropdown-notifications-item-icon bg-success"><i class="fas fa-truck"></i></div>
                    <div class="dropdown-notifications-item-content">
                        <div class="dropdown-notifications-item-content-details">Hace 2 horas</div>
                        <div class="dropdown-notifications-item-content-text">Despacho completado</div>
                    </div>
                </a>
                <a class="dropdown-item dropdown-notifications-footer" href="#!">Ver todas las notificaciones</a>
            </div>
        </li>
        
        <!-- Messages Dropdown-->
        <li class="nav-item dropdown no-caret d-none d-sm-block me-3 dropdown-notifications">
            <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownMessages" href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-envelope fa-fw"></i>
                <span class="position-absolute top-0 end-0 translate-middle badge rounded-pill bg-danger">2</span>
            </a>
            <div class="dropdown-menu dropdown-menu-end border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownMessages">
                <h6 class="dropdown-header dropdown-notifications-header">
                    <i class="fas fa-envelope me-2"></i>
                    Centro de Mensajes
                </h6>
                <!-- Message Item 1-->
                <a class="dropdown-item dropdown-notifications-item" href="#!">
                    <img class="dropdown-notifications-item-img" src="https://ui-avatars.com/api/?name=Dr.+Torres&background=4e73df&color=ffffff" />
                    <div class="dropdown-notifications-item-content">
                        <div class="dropdown-notifications-item-content-text">Necesito confirmar la cirugía del paciente Rodríguez.</div>
                        <div class="dropdown-notifications-item-content-details">Dr. Torres · 58m</div>
                    </div>
                </a>
                <!-- Message Item 2-->
                <a class="dropdown-item dropdown-notifications-item" href="#!">
                    <img class="dropdown-notifications-item-img" src="https://ui-avatars.com/api/?name=Ana+Mendez&background=4e73df&color=ffffff" />
                    <div class="dropdown-notifications-item-content">
                        <div class="dropdown-notifications-item-content-text">Por favor actualizar el inventario de equipos.</div>
                        <div class="dropdown-notifications-item-content-details">Ana Méndez · 2h</div>
                    </div>
                </a>
                <a class="dropdown-item dropdown-notifications-footer" href="#!">Ver todos los mensajes</a>
            </div>
        </li>
        
        <!-- User Dropdown-->
        <li class="nav-item dropdown no-caret dropdown-user me-3 me-lg-4">
            <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownUserImage" href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img class="img-fluid" src="https://ui-avatars.com/api/?name={{ Auth::user()->name ?? 'Usuario' }}&background=4e73df&color=ffffff" />
            </a>
            <div class="dropdown-menu dropdown-menu-end border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownUserImage">
                <h6 class="dropdown-header d-flex align-items-center">
                    <img class="dropdown-user-img" src="https://ui-avatars.com/api/?name={{ Auth::user()->name ?? 'Usuario' }}&background=4e73df&color=ffffff" />
                    <div class="dropdown-user-details">
                        <div class="dropdown-user-details-name">{{ Auth::user()->name ?? 'Usuario' }}</div>
                        <div class="dropdown-user-details-email">{{ Auth::user()->email ?? 'usuario@ejemplo.com' }}</div>
                    </div>
                </h6>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                    <div class="dropdown-item-icon"><i class="fas fa-user"></i></div>
                    Mi Perfil
                </a>
                <a class="dropdown-item" href="#">
                    <div class="dropdown-item-icon"><i class="fas fa-cog"></i></div>
                    Configuración
                </a>
                <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <div class="dropdown-item-icon"><i class="fas fa-sign-out-alt"></i></div>
                    Cerrar Sesión
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>
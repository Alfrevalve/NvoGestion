<!-- Sidebar -->
<nav class="sidenav shadow-right sidenav-light">
    <div class="sidenav-menu">
        <div class="nav accordion" id="accordionSidenav">
            <!-- Sidenav Menu Heading (Core)-->
            <div class="sidenav-menu-heading">Principal</div>

            <!-- Sidenav Link (Dashboard)-->
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <div class="nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                Dashboard
            </a>

            <!-- Sidenav Heading (Gestión Médica)-->
            <div class="sidenav-menu-heading">Gestión Médica</div>

            <!-- Sidenav Accordion (Cirugías)-->
            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseCirugias" aria-expanded="false" aria-controls="collapseCirugias">
                <div class="nav-link-icon"><i class="fas fa-procedures"></i></div>
                Cirugías
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseCirugias" data-bs-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav">
                    <a class="nav-link" href="{{ route('cirugias.index') }}">Listado</a>
                    <a class="nav-link" href="{{ route('cirugias.create') }}">Nueva Cirugía</a>
                    <a class="nav-link" href="{{ route('cirugias.calendario') }}">Calendario</a>
                </nav>
            </div>

            <!-- Sidenav Accordion (Pacientes)-->
            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapsePacientes" aria-expanded="false" aria-controls="collapsePacientes">
                <div class="nav-link-icon"><i class="fas fa-user-injured"></i></div>
                Pacientes
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapsePacientes" data-bs-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav">
                    <a class="nav-link" href="{{ route('pacientes.index') }}">Listado</a>
                    <a class="nav-link" href="{{ route('pacientes.create') }}">Nuevo Paciente</a>
                </nav>
            </div>

            <!-- Sidenav Accordion (Médicos)-->
            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseMedicos" aria-expanded="false" aria-controls="collapseMedicos">
                <div class="nav-link-icon"><i class="fas fa-user-md"></i></div>
                Médicos
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseMedicos" data-bs-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav">
                    <a class="nav-link" href="{{ route('medicos.index') }}">Listado</a>
                    <a class="nav-link" href="{{ route('medicos.create') }}">Nuevo Médico</a>
                </nav>
            </div>

            <!-- Sidenav Heading (Almacén)-->
            <div class="sidenav-menu-heading">Almacén</div>

            <!-- Sidenav Link (Inventario)-->
            <a class="nav-link" href="{{ route('inventario.index') }}">
                <div class="nav-link-icon"><i class="fas fa-boxes"></i></div>
                Inventario
            </a>

            <!-- Sidenav Link (Equipos)-->
            <a class="nav-link" href="{{ route('equipos.index') }}">
                <div class="nav-link-icon"><i class="fas fa-toolbox"></i></div>
                Equipos
            </a>

            <!-- Sidenav Heading (Reportes)-->
            <div class="sidenav-menu-heading">Reportes</div>

            <!-- Sidenav Link (Reportes)-->
            <a class="nav-link" href="{{ route('reportes.cirugias') }}">
                <div class="nav-link-icon"><i class="fas fa-chart-bar"></i></div>
                Reportes de Cirugías
            </a>

            <!-- Sidenav Link (Estadísticas)-->
            <a class="nav-link" href="{{ route('reportes.estadisticas') }}">
                <div class="nav-link-icon"><i class="fas fa-chart-pie"></i></div>
                Estadísticas
            </a>

            <!-- Sidenav Heading (Despacho)-->
            <div class="sidenav-menu-heading">Despacho</div>
            <a class="nav-link" href="{{ route('despacho.index') }}">
                <div class="nav-link-icon"><i class="fas fa-truck"></i></div>
                Despacho
            </a>

            <!-- Sidenav Accordion (Usuarios)-->
            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseUsuarios" aria-expanded="false" aria-controls="collapseUsuarios">
                <div class="nav-link-icon"><i class="fas fa-users"></i></div>
                Usuarios
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseUsuarios" data-bs-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav">
                    <a class="nav-link" href="{{ route('admin.usuarios.index') }}">Listado</a>
                    <a class="nav-link" href="{{ route('admin.usuarios.create') }}">Nuevo Usuario</a>
                    <a class="nav-link" href="{{ route('admin.roles.index') }}">Roles</a>
                    <a class="nav-link" href="{{ route('admin.permissions.index') }}">Permisos</a>
                </nav>
            </div>

            <!-- Sidenav Link (Configuración)-->
            <a class="nav-link" href="{{ route('configuracion.index') }}">
                <div class="nav-link-icon"><i class="fas fa-cog"></i></div>
                Configuración
            </a>
        </div>
    </div>

    <!-- Sidenav Footer-->
    <div class="sidenav-footer">
        <div class="sidenav-footer-content">
            <div class="sidenav-footer-subtitle">Conectado como:</div>
            <div class="sidenav-footer-title">{{ Auth::user()->name ?? 'Usuario' }}</div>
        </div>
    </div>
</nav>

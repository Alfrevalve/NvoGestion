<nav class="navbar">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('dashboard') }}">GesVitalPro</a>
        <div class="navbar-nav">
            <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>

            <div class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownCirugias" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Cirugías
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownCirugias">
                    <li><a class="dropdown-item" href="{{ route('cirugias.index') }}">Lista de Cirugías</a></li>
                    <li><a class="dropdown-item" href="{{ route('cirugias.create') }}">Nueva Cirugía</a></li>
                    <li><a class="dropdown-item" href="{{ route('cirugias.calendario') }}">Calendario</a></li>
                </ul>
            </div>

            <div class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownAlmacen" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Almacén
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownAlmacen">
                    <li><a class="dropdown-item" href="{{ route('almacen.index') }}">Inventario</a></li>
                    <li><a class="dropdown-item" href="{{ route('almacen.create') }}">Nuevo Item</a></li>
                </ul>
            </div>

            <div class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownDespacho" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Despacho
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownDespacho">
                    <li><a class="dropdown-item" href="{{ route('despacho.index') }}">Lista de Despachos</a></li>
                    <li><a class="dropdown-item" href="{{ route('despacho.create') }}">Nuevo Despacho</a></li>
                </ul>
            </div>

            <div class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownAdmin" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Administración
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownAdmin">
                    <li><a class="dropdown-item" href="{{ route('admin.users.index') }}">Usuarios</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.roles.index') }}">Roles</a></li>
                </ul>
            </div>

            <a class="nav-link" href="{{ route('profile.edit') }}">Perfil</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-link btn btn-link">Cerrar sesión</button>
            </form>
        </div>
    </div>
</nav>

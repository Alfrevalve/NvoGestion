@extends('layouts.sb-admin-pro')

@section('title', 'Administración de Usuarios')

@section('content')
    <div class="container-fluid px-4">
        <div class="page-header-content">
            <div class="row align-items-center justify-content-between pt-3">
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i class="fas fa-users"></i></div>
                        Administración de Usuarios
                    </h1>
                </div>
                <div class="col-12 col-xl-auto mb-3">
                    <a class="btn btn-sm btn-primary" href="{{ route('admin.usuarios.create') }}">
                        <i class="fas fa-user-plus mr-1"></i>
                        Nuevo Usuario
                    </a>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-table me-1"></i>
                    Usuarios del Sistema
                </div>
                <div class="d-flex">
                    <div class="dropdown me-2">
                        <button class="btn btn-sm btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            Rol
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li><a class="dropdown-item" href="#">Todos</a></li>
                            <li><a class="dropdown-item" href="#">Administrador</a></li>
                            <li><a class="dropdown-item" href="#">Médico</a></li>
                            <li><a class="dropdown-item" href="#">Asistente</a></li>
                        </ul>
                    </div>
                    <input type="text" class="form-control form-control-sm" placeholder="Buscar usuario...">
                </div>
            </div>
            <div class="card-body">
                <table id="datatablesSimple" class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Estado</th>
                            <th>Último Acceso</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Admin Usuario</td>
                            <td>admin@example.com</td>
                            <td><span class="badge bg-primary">Administrador</span></td>
                            <td><span class="badge bg-success">Activo</span></td>
                            <td>2025-03-25 09:45:12</td>
                            <td>
                                <a href="#" class="btn btn-datatable btn-icon btn-transparent-dark me-2"><i class="fas fa-edit"></i></a>
                                <a href="#" class="btn btn-datatable btn-icon btn-transparent-dark me-2"><i class="fas fa-key"></i></a>
                                <a href="#" class="btn btn-datatable btn-icon btn-transparent-dark"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Carlos Rodríguez</td>
                            <td>carlos@example.com</td>
                            <td><span class="badge bg-info">Médico</span></td>
                            <td><span class="badge bg-success">Activo</span></td>
                            <td>2025-03-24 15:32:08</td>
                            <td>
                                <a href="#" class="btn btn-datatable btn-icon btn-transparent-dark me-2"><i class="fas fa-edit"></i></a>
                                <a href="#" class="btn btn-datatable btn-icon btn-transparent-dark me-2"><i class="fas fa-key"></i></a>
                                <a href="#" class="btn btn-datatable btn-icon btn-transparent-dark"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Ana Martínez</td>
                            <td>ana@example.com</td>
                            <td><span class="badge bg-info">Médico</span></td>
                            <td><span class="badge bg-success">Activo</span></td>
                            <td>2025-03-25 08:15:47</td>
                            <td>
                                <a href="#" class="btn btn-datatable btn-icon btn-transparent-dark me-2"><i class="fas fa-edit"></i></a>
                                <a href="#" class="btn btn-datatable btn-icon btn-transparent-dark me-2"><i class="fas fa-key"></i></a>
                                <a href="#" class="btn btn-datatable btn-icon btn-transparent-dark"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>María López</td>
                            <td>maria@example.com</td>
                            <td><span class="badge bg-secondary">Asistente</span></td>
                            <td><span class="badge bg-success">Activo</span></td>
                            <td>2025-03-23 10:22:35</td>
                            <td>
                                <a href="#" class="btn btn-datatable btn-icon btn-transparent-dark me-2"><i class="fas fa-edit"></i></a>
                                <a href="#" class="btn btn-datatable btn-icon btn-transparent-dark me-2"><i class="fas fa-key"></i></a>
                                <a href="#" class="btn btn-datatable btn-icon btn-transparent-dark"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Juan Pérez</td>
                            <td>juan@example.com</td>
                            <td><span class="badge bg-secondary">Asistente</span></td>
                            <td><span class="badge bg-danger">Inactivo</span></td>
                            <td>2025-02-15 14:08:22</td>
                            <td>
                                <a href="#" class="btn btn-datatable btn-icon btn-transparent-dark me-2"><i class="fas fa-edit"></i></a>
                                <a href="#" class="btn btn-datatable btn-icon btn-transparent-dark me-2"><i class="fas fa-key"></i></a>
                                <a href="#" class="btn btn-datatable btn-icon btn-transparent-dark"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
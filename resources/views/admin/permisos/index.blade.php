@extends('layouts.sb-admin-pro')

@section('title', 'Administración de Permisos')

@section('content')
    <div class="container-fluid px-4">
        <div class="page-header-content">
            <div class="row align-items-center justify-content-between pt-3">
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i class="fas fa-key"></i></div>
                        Administración de Permisos
                    </h1>
                </div>
                <div class="col-12 col-xl-auto mb-3">
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createPermissionModal">
                        <i class="fas fa-plus mr-1"></i>
                        Nuevo Permiso
                    </button>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-table me-1"></i>
                    Permisos del Sistema
                </div>
                <div class="d-flex">
                    <div class="dropdown me-2">
                        <button class="btn btn-sm btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            Módulo
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li><a class="dropdown-item" href="#">Todos</a></li>
                            <li><a class="dropdown-item" href="#">Cirugías</a></li>
                            <li><a class="dropdown-item" href="#">Pacientes</a></li>
                            <li><a class="dropdown-item" href="#">Equipos</a></li>
                            <li><a class="dropdown-item" href="#">Reportes</a></li>
                            <li><a class="dropdown-item" href="#">Administración</a></li>
                        </ul>
                    </div>
                    <input type="text" class="form-control form-control-sm" placeholder="Buscar permiso...">
                </div>
            </div>
            <div class="card-body">
                <table id="datatablesSimple" class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Clave</th>
                            <th>Módulo</th>
                            <th>Descripción</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Ver Cirugías</td>
                            <td>cirugias.view</td>
                            <td>Cirugías</td>
                            <td>Permite ver el listado de cirugías</td>
                            <td>
                                <a href="#" class="btn btn-datatable btn-icon btn-transparent-dark me-2" data-bs-toggle="modal" data-bs-target="#editPermissionModal"><i class="fas fa-edit"></i></a>
                                <a href="#" class="btn btn-datatable btn-icon btn-transparent-dark"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Crear Cirugías</td>
                            <td>cirugias.create</td>
                            <td>Cirugías</td>
                            <td>Permite crear nuevas cirugías</td>
                            <td>
                                <a href="#" class="btn btn-datatable btn-icon btn-transparent-dark me-2" data-bs-toggle="modal" data-bs-target="#editPermissionModal"><i class="fas fa-edit"></i></a>
                                <a href="#" class="btn btn-datatable btn-icon btn-transparent-dark"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Editar Cirugías</td>
                            <td>cirugias.edit</td>
                            <td>Cirugías</td>
                            <td>Permite editar cirugías existentes</td>
                            <td>
                                <a href="#" class="btn btn-datatable btn-icon btn-transparent-dark me-2" data-bs-toggle="modal" data-bs-target="#editPermissionModal"><i class="fas fa-edit"></i></a>
                                <a href="#" class="btn btn-datatable btn-icon btn-transparent-dark"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Eliminar Cirugías</td>
                            <td>cirugias.delete</td>
                            <td>Cirugías</td>
                            <td>Permite eliminar cirugías</td>
                            <td>
                                <a href="#" class="btn btn-datatable btn-icon btn-transparent-dark me-2" data-bs-toggle="modal" data-bs-target="#editPermissionModal"><i class="fas fa-edit"></i></a>
                                <a href="#" class="btn btn-datatable btn-icon btn-transparent-dark"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Ver Pacientes</td>
                            <td>pacientes.view</td>
                            <td>Pacientes</td>
                            <td>Permite ver el listado de pacientes</td>
                            <td>
                                <a href="#" class="btn btn-datatable btn-icon btn-transparent-dark me-2" data-bs-toggle="modal" data-bs-target="#editPermissionModal"><i class="fas fa-edit"></i></a>
                                <a href="#" class="btn btn-datatable btn-icon btn-transparent-dark"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>Ver Equipos</td>
                            <td>equipos.view</td>
                            <td>Equipos</td>
                            <td>Permite ver el listado de equipos</td>
                            <td>
                                <a href="#" class="btn btn-datatable btn-icon btn-transparent-dark me-2" data-bs-toggle="modal" data-bs-target="#editPermissionModal"><i class="fas fa-edit"></i></a>
                                <a href="#" class="btn btn-datatable btn-icon btn-transparent-dark"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td>Ver Reportes</td>
                            <td>reportes.view</td>
                            <td>Reportes</td>
                            <td>Permite ver los reportes del sistema</td>
                            <td>
                                <a href="#" class="btn btn-datatable btn-icon btn-transparent-dark me-2" data-bs-toggle="modal" data-bs-target="#editPermissionModal"><i class="fas fa-edit"></i></a>
                                <a href="#" class="btn btn-datatable btn-icon btn-transparent-dark"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Crear Permiso -->
    <div class="modal fade" id="createPermissionModal" tabindex="-1" aria-labelledby="createPermissionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createPermissionModalLabel">Crear Nuevo Permiso</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="permissionName" class="form-label">Nombre del Permiso</label>
                            <input type="text" class="form-control" id="permissionName" required>
                        </div>
                        <div class="mb-3">
                            <label for="permissionKey" class="form-label">Clave</label>
                            <input type="text" class="form-control" id="permissionKey" required>
                            <div class="form-text">Formato recomendado: modulo.accion (ej: cirugias.view)</div>
                        </div>
                        <div class="mb-3">
                            <label for="permissionModule" class="form-label">Módulo</label>
                            <select class="form-select" id="permissionModule" required>
                                <option value="">Seleccione un módulo...</option>
                                <option value="cirugias">Cirugías</option>
                                <option value="pacientes">Pacientes</option>
                                <option value="equipos">Equipos</option>
                                <option value="reportes">Reportes</option>
                                <option value="admin">Administración</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="permissionDescription" class="form-label">Descripción</label>
                            <textarea class="form-control" id="permissionDescription" rows="2"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary">Guardar Permiso</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Editar Permiso -->
    <div class="modal fade" id="editPermissionModal" tabindex="-1" aria-labelledby="editPermissionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPermissionModalLabel">Editar Permiso</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="editPermissionName" class="form-label">Nombre del Permiso</label>
                            <input type="text" class="form-control" id="editPermissionName" value="Ver Cirugías" required>
                        </div>
                        <div class="mb-3">
                            <label for="editPermissionKey" class="form-label">Clave</label>
                            <input type="text" class="form-control" id="editPermissionKey" value="cirugias.view" required>
                            <div class="form-text">Formato recomendado: modulo.accion (ej: cirugias.view)</div>
                        </div>
                        <div class="mb-3">
                            <label for="editPermissionModule" class="form-label">Módulo</label>
                            <select class="form-select" id="editPermissionModule" required>
                                <option value="">Seleccione un módulo...</option>
                                <option value="cirugias" selected>Cirugías</option>
                                <option value="pacientes">Pacientes</option>
                                <option value="equipos">Equipos</option>
                                <option value="reportes">Reportes</option>
                                <option value="admin">Administración</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editPermissionDescription" class="form-label">Descripción</label>
                            <textarea class="form-control" id="editPermissionDescription" rows="2">Permite ver el listado de cirugías</textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary">Actualizar Permiso</button>
                </div>
            </div>
        </div>
    </div>
@endsection
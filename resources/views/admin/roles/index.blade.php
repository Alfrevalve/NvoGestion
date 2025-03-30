@extends('layouts.sb-admin-pro')

@section('title', 'Administración de Roles')

@section('content')
    <div class="container-fluid px-4">
        <div class="page-header-content">
            <div class="row align-items-center justify-content-between pt-3">
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i class="fas fa-user-tag"></i></div>
                        Administración de Roles
                    </h1>
                </div>
                <div class="col-12 col-xl-auto mb-3">
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createRoleModal">
                        <i class="fas fa-plus mr-1"></i>
                        Nuevo Rol
                    </button>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Roles del Sistema
            </div>
            <div class="card-body">
                <table id="datatablesSimple" class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Usuarios</th>
                            <th>Permisos</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Administrador</td>
                            <td>Control total del sistema</td>
                            <td>1</td>
                            <td>Todos</td>
                            <td>
                                <a href="#" class="btn btn-datatable btn-icon btn-transparent-dark me-2" data-bs-toggle="modal" data-bs-target="#editRoleModal"><i class="fas fa-edit"></i></a>
                                <a href="#" class="btn btn-datatable btn-icon btn-transparent-dark me-2" data-bs-toggle="modal" data-bs-target="#permissionsModal"><i class="fas fa-key"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Médico</td>
                            <td>Gestión de cirugías y pacientes</td>
                            <td>2</td>
                            <td>8</td>
                            <td>
                                <a href="#" class="btn btn-datatable btn-icon btn-transparent-dark me-2" data-bs-toggle="modal" data-bs-target="#editRoleModal"><i class="fas fa-edit"></i></a>
                                <a href="#" class="btn btn-datatable btn-icon btn-transparent-dark me-2" data-bs-toggle="modal" data-bs-target="#permissionsModal"><i class="fas fa-key"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Asistente</td>
                            <td>Gestión básica y reportes</td>
                            <td>2</td>
                            <td>5</td>
                            <td>
                                <a href="#" class="btn btn-datatable btn-icon btn-transparent-dark me-2" data-bs-toggle="modal" data-bs-target="#editRoleModal"><i class="fas fa-edit"></i></a>
                                <a href="#" class="btn btn-datatable btn-icon btn-transparent-dark me-2" data-bs-toggle="modal" data-bs-target="#permissionsModal"><i class="fas fa-key"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Crear Rol -->
    <div class="modal fade" id="createRoleModal" tabindex="-1" aria-labelledby="createRoleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createRoleModalLabel">Crear Nuevo Rol</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="roleName" class="form-label">Nombre del Rol</label>
                            <input type="text" class="form-control" id="roleName" required>
                        </div>
                        <div class="mb-3">
                            <label for="roleDescription" class="form-label">Descripción</label>
                            <textarea class="form-control" id="roleDescription" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary">Guardar Rol</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Editar Rol -->
    <div class="modal fade" id="editRoleModal" tabindex="-1" aria-labelledby="editRoleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editRoleModalLabel">Editar Rol</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="editRoleName" class="form-label">Nombre del Rol</label>
                            <input type="text" class="form-control" id="editRoleName" value="Médico" required>
                        </div>
                        <div class="mb-3">
                            <label for="editRoleDescription" class="form-label">Descripción</label>
                            <textarea class="form-control" id="editRoleDescription" rows="3">Gestión de cirugías y pacientes</textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary">Actualizar Rol</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Permisos -->
    <div class="modal fade" id="permissionsModal" tabindex="-1" aria-labelledby="permissionsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="permissionsModalLabel">Permisos del Rol: Médico</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="mb-3">Cirugías</h6>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="viewSurgeries" checked>
                                <label class="form-check-label" for="viewSurgeries">Ver Cirugías</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="createSurgeries" checked>
                                <label class="form-check-label" for="createSurgeries">Crear Cirugías</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="editSurgeries" checked>
                                <label class="form-check-label" for="editSurgeries">Editar Cirugías</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="deleteSurgeries">
                                <label class="form-check-label" for="deleteSurgeries">Eliminar Cirugías</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="mb-3">Pacientes</h6>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="viewPatients" checked>
                                <label class="form-check-label" for="viewPatients">Ver Pacientes</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="createPatients" checked>
                                <label class="form-check-label" for="createPatients">Crear Pacientes</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="editPatients" checked>
                                <label class="form-check-label" for="editPatients">Editar Pacientes</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="deletePatients">
                                <label class="form-check-label" for="deletePatients">Eliminar Pacientes</label>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="mb-3">Equipos</h6>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="viewEquipment" checked>
                                <label class="form-check-label" for="viewEquipment">Ver Equipos</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="createEquipment">
                                <label class="form-check-label" for="createEquipment">Crear Equipos</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="editEquipment">
                                <label class="form-check-label" for="editEquipment">Editar Equipos</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="deleteEquipment">
                                <label class="form-check-label" for="deleteEquipment">Eliminar Equipos</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="mb-3">Reportes</h6>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="viewReports" checked>
                                <label class="form-check-label" for="viewReports">Ver Reportes</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="exportReports">
                                <label class="form-check-label" for="exportReports">Exportar Reportes</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary">Guardar Permisos</button>
                </div>
            </div>
        </div>
    </div>
@endsection
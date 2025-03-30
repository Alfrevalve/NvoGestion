@extends('layouts.sb-admin-pro')

@section('title', 'Listado de Pacientes')

@section('content')
    <div class="container-fluid px-4">
        <div class="page-header-content">
            <div class="row align-items-center justify-content-between pt-3">
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i class="fas fa-user-injured"></i></div>
                        Listado de Pacientes
                    </h1>
                </div>
                <div class="col-12 col-xl-auto mb-3">
                    <a class="btn btn-sm btn-primary" href="{{ route('pacientes.create') }}">
                        <i class="fas fa-plus mr-1"></i>
                        Nuevo Paciente
                    </a>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Pacientes Registrados
            </div>
            <div class="card-body">
                <table id="datatablesSimple" class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th>Documento</th>
                            <th>Teléfono</th>
                            <th>Email</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Aquí se mostrarán los pacientes -->
                        <tr>
                            <td>1</td>
                            <td>Juan</td>
                            <td>Pérez</td>
                            <td>12345678</td>
                            <td>555-123-456</td>
                            <td>juan@example.com</td>
                            <td>
                                <a href="#" class="btn btn-datatable btn-icon btn-transparent-dark me-2"><i class="fas fa-edit"></i></a>
                                <a href="#" class="btn btn-datatable btn-icon btn-transparent-dark"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>María</td>
                            <td>González</td>
                            <td>87654321</td>
                            <td>555-654-321</td>
                            <td>maria@example.com</td>
                            <td>
                                <a href="#" class="btn btn-datatable btn-icon btn-transparent-dark me-2"><i class="fas fa-edit"></i></a>
                                <a href="#" class="btn btn-datatable btn-icon btn-transparent-dark"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
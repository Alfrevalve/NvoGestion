@extends('layouts.sb-admin-pro')

@section('title', 'Listado de Médicos')

@section('content')
    <div class="container-fluid px-4">
        <div class="page-header-content">
            <div class="row align-items-center justify-content-between pt-3">
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i class="fas fa-user-md"></i></div>
                        Listado de Médicos
                    </h1>
                </div>
                <div class="col-12 col-xl-auto mb-3">
                    <a class="btn btn-sm btn-primary" href="{{ route('medicos.create') }}">
                        <i class="fas fa-plus mr-1"></i>
                        Nuevo Médico
                    </a>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Médicos Registrados
            </div>
            <div class="card-body">
                <table id="datatablesSimple" class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Especialidad</th>
                            <th>Colegiatura</th>
                            <th>Teléfono</th>
                            <th>Email</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Aquí se mostrarán los médicos -->
                        <tr>
                            <td>1</td>
                            <td>Dr. Carlos Rodríguez</td>
                            <td>Traumatología</td>
                            <td>CMP-12345</td>
                            <td>555-111-222</td>
                            <td>carlos@example.com</td>
                            <td>
                                <a href="#" class="btn btn-datatable btn-icon btn-transparent-dark me-2"><i class="fas fa-edit"></i></a>
                                <a href="#" class="btn btn-datatable btn-icon btn-transparent-dark"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Dra. Ana Martínez</td>
                            <td>Neurocirugía</td>
                            <td>CMP-54321</td>
                            <td>555-333-444</td>
                            <td>ana@example.com</td>
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
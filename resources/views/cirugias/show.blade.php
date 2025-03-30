@extends('layouts.sb-admin-pro')

@section('title', 'Detalle de Cirugía')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detalle de Cirugía</h1>
        <div>
            <a href="{{ route('cirugias.edit', $cirugia->id) }}" class="btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-edit fa-sm text-white-50"></i> Editar
            </a>
            <a href="{{ route('cirugias.index') }}" class="btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Volver al listado
            </a>
        </div>
    </div>

    <!-- Surgery Details Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Información de la Cirugía</h6>
            <span class="badge badge-{{ $cirugia->estado == 'Programada' ? 'primary' : ($cirugia->estado == 'Completada' ? 'success' : 'warning') }}">
                {{ $cirugia->estado }}
            </span>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 30%">Código:</th>
                            <td><strong>{{ $cirugia->codigo }}</strong></td>
                        </tr>
                        <tr>
                            <th>Nombre:</th>
                            <td>{{ $cirugia->nombre }}</td>
                        </tr>
                        <tr>
                            <th>Fecha:</th>
                            <td>{{ date('d/m/Y', strtotime($cirugia->fecha)) }}</td>
                        </tr>
                        <tr>
                            <th>Estado:</th>
                            <td>
                                <span class="badge badge-{{ $cirugia->estado == 'Programada' ? 'primary' : ($cirugia->estado == 'Completada' ? 'success' : 'warning') }}">
                                    {{ $cirugia->estado }}
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="font-weight-bold text-primary mb-0">Descripción</h6>
                        </div>
                        <div class="card-body">
                            <p>{{ $cirugia->descripcion }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Patient Information -->
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Información del Paciente</h6>
                </div>
                <div class="card-body">
                    @if(isset($cirugia->paciente))
                        <div class="mb-3">
                            <strong>Nombre:</strong> {{ $cirugia->paciente->nombre }}
                        </div>
                        <div class="mb-3">
                            <strong>Documento:</strong> {{ $cirugia->paciente->documento }}
                        </div>
                        <div class="mb-3">
                            <strong>Fecha de Nacimiento:</strong> {{ date('d/m/Y', strtotime($cirugia->paciente->fecha_nacimiento)) }}
                        </div>
                        <div class="mb-3">
                            <strong>Género:</strong> {{ $cirugia->paciente->genero }}
                        </div>
                        <div class="mb-3">
                            <strong>Teléfono:</strong> {{ $cirugia->paciente->telefono }}
                        </div>
                        <div class="mb-3">
                            <strong>Email:</strong> {{ $cirugia->paciente->email }}
                        </div>
                        <a href="{{ route('pacientes.show', $cirugia->paciente->id) }}" class="btn btn-sm btn-info">
                            <i class="fas fa-user"></i> Ver Paciente
                        </a>
                    @else
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle mr-2"></i> No hay paciente asignado a esta cirugía.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Doctor Information -->
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Información del Médico</h6>
                </div>
                <div class="card-body">
                    @if(isset($cirugia->medico))
                        <div class="mb-3">
                            <strong>Nombre:</strong> {{ $cirugia->medico->nombre }}
                        </div>
                        <div class="mb-3">
                            <strong>Especialidad:</strong> {{ $cirugia->medico->especialidad }}
                        </div>
                        <div class="mb-3">
                            <strong>CMP:</strong> {{ $cirugia->medico->cmp }}
                        </div>
                        <div class="mb-3">
                            <strong>Teléfono:</strong> {{ $cirugia->medico->telefono }}
                        </div>
                        <div class="mb-3">
                            <strong>Email:</strong> {{ $cirugia->medico->email }}
                        </div>
                        <a href="{{ route('medicos.show', $cirugia->medico->id) }}" class="btn btn-sm btn-info">
                            <i class="fas fa-user-md"></i> Ver Médico
                        </a>
                    @else
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle mr-2"></i> No hay médico asignado a esta cirugía.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Equipment Used -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Equipos Utilizados</h6>
        </div>
        <div class="card-body">
            @if(isset($cirugia->equipos) && $cirugia->equipos->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cirugia->equipos as $equipo)
                            <tr>
                                <td>{{ $equipo->codigo }}</td>
                                <td>{{ $equipo->nombre }}</td>
                                <td>{{ Str::limit($equipo->descripcion, 50) }}</td>
                                <td>
                                    <span class="badge badge-{{ $equipo->estado == 'Activo' ? 'success' : 'danger' }}">
                                        {{ $equipo->estado }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('equipos.show', $equipo->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info">
                    <i class="fas fa-info-circle mr-2"></i> No hay equipos asignados a esta cirugía.
                </div>
            @endif
        </div>
    </div>

    <!-- Notes and Observations -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Notas y Observaciones</h6>
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                <i class="fas fa-info-circle mr-2"></i> No hay notas u observaciones registradas para esta cirugía.
            </div>
        </div>
    </div>
</div>
@endsection
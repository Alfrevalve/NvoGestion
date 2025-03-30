@extends('layouts.sb-admin-pro')

@section('title', 'Detalle de Paciente')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detalle de Paciente</h1>
        <div>
            <a href="{{ route('pacientes.edit', $paciente->id) }}" class="btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-edit fa-sm text-white-50"></i> Editar
            </a>
            <a href="{{ route('pacientes.index') }}" class="btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Volver al listado
            </a>
        </div>
    </div>

    <!-- Patient Details Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Información del Paciente</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 30%">Nombre:</th>
                            <td><strong>{{ $paciente->nombre }}</strong></td>
                        </tr>
                        <tr>
                            <th>Documento:</th>
                            <td>{{ $paciente->documento }}</td>
                        </tr>
                        <tr>
                            <th>Fecha de Nacimiento:</th>
                            <td>{{ date('d/m/Y', strtotime($paciente->fecha_nacimiento)) }}</td>
                        </tr>
                        <tr>
                            <th>Edad:</th>
                            <td>{{ \Carbon\Carbon::parse($paciente->fecha_nacimiento)->age }} años</td>
                        </tr>
                        <tr>
                            <th>Género:</th>
                            <td>{{ $paciente->genero }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 30%">Teléfono:</th>
                            <td>{{ $paciente->telefono }}</td>
                        </tr>
                        <tr>
                            <th>Dirección:</th>
                            <td>{{ $paciente->direccion }}</td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td>{{ $paciente->email }}</td>
                        </tr>
                        <tr>
                            <th>Creado:</th>
                            <td>{{ date('d/m/Y', strtotime($paciente->created_at)) }}</td>
                        </tr>
                        <tr>
                            <th>Actualizado:</th>
                            <td>{{ date('d/m/Y', strtotime($paciente->updated_at)) }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Medical History -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Historial Médico</h6>
            <a href="{{ route('cirugias.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus fa-sm"></i> Nueva Cirugía
            </a>
        </div>
        <div class="card-body">
            @if(isset($paciente->cirugias) && $paciente->cirugias->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>Fecha</th>
                                <th>Médico</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($paciente->cirugias as $cirugia)
                            <tr>
                                <td>{{ $cirugia->codigo }}</td>
                                <td>{{ $cirugia->nombre }}</td>
                                <td>{{ date('d/m/Y', strtotime($cirugia->fecha)) }}</td>
                                <td>{{ $cirugia->medico->nombre ?? 'No asignado' }}</td>
                                <td>
                                    <span class="badge badge-{{ $cirugia->estado == 'Programada' ? 'primary' : ($cirugia->estado == 'Completada' ? 'success' : 'warning') }}">
                                        {{ $cirugia->estado }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('cirugias.show', $cirugia->id) }}" class="btn btn-sm btn-info">
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
                    <i class="fas fa-info-circle mr-2"></i> Este paciente no tiene cirugías registradas.
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
                <i class="fas fa-info-circle mr-2"></i> No hay notas u observaciones registradas para este paciente.
            </div>
        </div>
    </div>
</div>
@endsection
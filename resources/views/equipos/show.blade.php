@extends('layouts.sb-admin-pro')

@section('title', 'Detalle de Equipo')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detalle de Equipo</h1>
        <div>
            <a href="{{ route('equipos.edit', $equipo->id) }}" class="btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-edit fa-sm text-white-50"></i> Editar
            </a>
            <a href="{{ route('equipos.index') }}" class="btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Volver al listado
            </a>
        </div>
    </div>

    <!-- Equipment Details Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Información del Equipo</h6>
            <span class="badge badge-{{ $equipo->estado == 'Activo' ? 'success' : 'danger' }}">
                {{ $equipo->estado }}
            </span>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 30%">Código:</th>
                            <td><strong>{{ $equipo->codigo }}</strong></td>
                        </tr>
                        <tr>
                            <th>Nombre:</th>
                            <td>{{ $equipo->nombre }}</td>
                        </tr>
                        <tr>
                            <th>Fecha de Ingreso:</th>
                            <td>{{ date('d/m/Y', strtotime($equipo->fecha_ingreso)) }}</td>
                        </tr>
                        <tr>
                            <th>Estado:</th>
                            <td>
                                <span class="badge badge-{{ $equipo->estado == 'Activo' ? 'success' : 'danger' }}">
                                    {{ $equipo->estado }}
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
                            <p>{{ $equipo->descripcion }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Equipment Usage History -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Historial de Uso</h6>
        </div>
        <div class="card-body">
            @if(isset($equipo->cirugias) && $equipo->cirugias->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Cirugía</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($equipo->cirugias as $cirugia)
                            <tr>
                                <td>{{ $cirugia->codigo }}</td>
                                <td>{{ $cirugia->nombre }}</td>
                                <td>{{ date('d/m/Y', strtotime($cirugia->fecha)) }}</td>
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
                    <i class="fas fa-info-circle mr-2"></i> Este equipo no ha sido utilizado en ninguna cirugía.
                </div>
            @endif
        </div>
    </div>

    <!-- Maintenance History -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Historial de Mantenimiento</h6>
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                <i class="fas fa-info-circle mr-2"></i> No hay registros de mantenimiento para este equipo.
            </div>
        </div>
    </div>
</div>
@endsection
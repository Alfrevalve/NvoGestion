@extends('layouts.sb-admin-pro')

@section('title', 'Detalle de Institución')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detalle de Institución</h1>
        <div>
            <a href="{{ route('instituciones.edit', $institucion->id) }}" class="btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-edit fa-sm text-white-50"></i> Editar
            </a>
            <a href="{{ route('instituciones.index') }}" class="btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Volver al listado
            </a>
        </div>
    </div>

    <!-- Institution Details Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Información de la Institución</h6>
            <span class="badge badge-{{ $institucion->estado == 'Activo' ? 'success' : 'danger' }}">
                {{ $institucion->estado }}
            </span>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 30%">Nombre:</th>
                            <td><strong>{{ $institucion->nombre }}</strong></td>
                        </tr>
                        <tr>
                            <th>Dirección:</th>
                            <td>{{ $institucion->direccion }}</td>
                        </tr>
                        <tr>
                            <th>Teléfono:</th>
                            <td>{{ $institucion->telefono }}</td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td>{{ $institucion->email }}</td>
                        </tr>
                        <tr>
                            <th>Estado:</th>
                            <td>
                                <span class="badge badge-{{ $institucion->estado == 'Activo' ? 'success' : 'danger' }}">
                                    {{ $institucion->estado }}
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="font-weight-bold text-primary mb-0">Estadísticas</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="card border-left-primary shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                        Cirugías</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        {{ isset($institucion->cirugias) ? $institucion->cirugias->count() : 0 }}
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-4">
                                    <div class="card border-left-success shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                        Médicos</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        {{ isset($institucion->medicos) ? $institucion->medicos->count() : 0 }}
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-user-md fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-header">
                            <h6 class="font-weight-bold text-primary mb-0">Ubicación</h6>
                        </div>
                        <div class="card-body">
                            <div class="text-center">
                                <img src="https://via.placeholder.com/400x200?text=Mapa+de+Ubicación" class="img-fluid" alt="Ubicación de la institución">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Surgery History -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Historial de Cirugías</h6>
            <a href="{{ route('cirugias.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus fa-sm"></i> Nueva Cirugía
            </a>
        </div>
        <div class="card-body">
            @if(isset($institucion->cirugias) && $institucion->cirugias->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>Fecha</th>
                                <th>Médico</th>
                                <th>Paciente</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($institucion->cirugias as $cirugia)
                            <tr>
                                <td>{{ $cirugia->codigo }}</td>
                                <td>{{ $cirugia->nombre }}</td>
                                <td>{{ date('d/m/Y', strtotime($cirugia->fecha)) }}</td>
                                <td>{{ $cirugia->medico->nombre ?? 'No asignado' }}</td>
                                <td>{{ $cirugia->paciente->nombre ?? 'No asignado' }}</td>
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
                    <i class="fas fa-info-circle mr-2"></i> Esta institución no tiene cirugías registradas.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
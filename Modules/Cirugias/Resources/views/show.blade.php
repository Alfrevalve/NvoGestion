@extends('adminlte::page')

@section('title', 'Detalles de Cirugía')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Detalles de Cirugía #{{ $cirugia->id }}</h1>
        <div>
            @can('editar cirugias')
                <a href="{{ route('modulo.cirugias.edit', $cirugia) }}" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Editar
                </a>
            @endcan
            <a href="{{ route('modulo.cirugias.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <!-- Información Principal -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Información Principal</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <dl>
                                <dt>Fecha</dt>
                                <dd>{{ $cirugia->fecha->format('d/m/Y') }}</dd>

                                <dt>Hora</dt>
                                <dd>{{ $cirugia->hora->format('H:i') }}</dd>

                                <dt>Tipo de Cirugía</dt>
                                <dd>{{ $cirugia->tipo_cirugia }}</dd>

                                <dt>Duración Estimada</dt>
                                <dd>{{ $cirugia->duracion_estimada ?? 'No especificada' }} minutos</dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <dl>
                                <dt>Estado</dt>
                                <dd>
                                    <span class="badge badge-{{ $cirugia->estado == 'pendiente' ? 'primary' :
                                                         ($cirugia->estado == 'programada' ? 'info' :
                                                         ($cirugia->estado == 'en proceso' ? 'warning' : 'success')) }}">
                                        {{ ucfirst($cirugia->estado) }}
                                    </span>
                                </dd>

                                <dt>Prioridad</dt>
                                <dd>
                                    <span class="badge badge-{{ $cirugia->prioridad == 'baja' ? 'success' :
                                                         ($cirugia->prioridad == 'media' ? 'info' :
                                                         ($cirugia->prioridad == 'alta' ? 'warning' : 'danger')) }}">
                                        {{ ucfirst($cirugia->prioridad) }}
                                    </span>
                                </dd>

                                <dt>Fecha de Creación</dt>
                                <dd>{{ $cirugia->created_at->format('d/m/Y H:i') }}</dd>

                                <dt>Última Actualización</dt>
                                <dd>{{ $cirugia->updated_at->format('d/m/Y H:i') }}</dd>
                            </dl>
                        </div>
                    </div>

                    @if($cirugia->observaciones)
                        <div class="mt-4">
                            <h5>Observaciones</h5>
                            <p class="text-muted">{{ $cirugia->observaciones }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Materiales -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Materiales Requeridos</h3>
                </div>
                <div class="card-body">
                    @if($cirugia->materiales->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Material</th>
                                        <th>Cantidad</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cirugia->materiales as $material)
                                        <tr>
                                            <td>{{ $material->nombre }}</td>
                                            <td>{{ $material->pivot->cantidad_usada }}</td>
                                            <td>
                                                @if($material->cantidad >= $material->pivot->cantidad_usada)
                                                    <span class="badge badge-success">Disponible</span>
                                                @else
                                                    <span class="badge badge-danger">Stock Insuficiente</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">No hay materiales asignados a esta cirugía.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Personal Asignado -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Personal Asignado</h3>
                </div>
                <div class="card-body">
                    <dl>
                        <dt><i class="fas fa-hospital mr-2"></i> Institución</dt>
                        <dd>{{ $cirugia->institucion->nombre }}</dd>

                        <dt><i class="fas fa-user-md mr-2"></i> Médico</dt>
                        <dd>{{ $cirugia->medico->nombre }}</dd>

                        <dt><i class="fas fa-user-nurse mr-2"></i> Instrumentista</dt>
                        <dd>{{ $cirugia->instrumentista->nombre }}</dd>
                    </dl>
                </div>
            </div>

            <!-- Equipo -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Equipo Asignado</h3>
                </div>
                <div class="card-body">
                    <dl>
                        <dt>Nombre del Equipo</dt>
                        <dd>{{ $cirugia->equipo->nombre }}</dd>

                        <dt>Estado del Equipo</dt>
                        <dd>
                            <span class="badge badge-{{ $cirugia->equipo->estado == 'disponible' ? 'success' :
                                                 ($cirugia->equipo->estado == 'en uso' ? 'warning' :
                                                 ($cirugia->equipo->estado == 'mantenimiento' ? 'info' : 'danger')) }}">
                                {{ ucfirst($cirugia->equipo->estado) }}
                            </span>
                        </dd>

                        @if($cirugia->equipo->fecha_mantenimiento)
                            <dt>Próximo Mantenimiento</dt>
                            <dd>{{ $cirugia->equipo->fecha_mantenimiento->format('d/m/Y') }}</dd>
                        @endif
                    </dl>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        // Aquí puedes agregar JavaScript personalizado
    </script>
@stop

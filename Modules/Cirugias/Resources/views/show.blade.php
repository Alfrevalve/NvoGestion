@extends('layouts.app')

@section('content')
<div class="container py-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-procedures me-2"></i>Detalles de la Cirugía #{{ $cirugia->id }}
            </h5>
            <span class="badge bg-{{ $cirugia->estado_color }} fs-6">{{ ucfirst($cirugia->estado) }}</span>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Información General</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="text-muted small">Tipo de Cirugía</label>
                                <p class="mb-0 fw-bold">{{ $cirugia->tipo_cirugia ?: 'No especificado' }}</p>
                            </div>

                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label class="text-muted small">Fecha</label>
                                    <p class="mb-0 fw-bold">{{ \Carbon\Carbon::parse($cirugia->fecha)->format('d/m/Y') }}</p>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="text-muted small">Hora</label>
                                    <p class="mb-0 fw-bold">{{ \Carbon\Carbon::parse($cirugia->hora)->format('H:i') }}</p>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="text-muted small">Duración Estimada</label>
                                <p class="mb-0 fw-bold">{{ $cirugia->duracion_estimada }} minutos</p>
                            </div>

                            <div class="mb-3">
                                <label class="text-muted small">Prioridad</label>
                                <p class="mb-0">
                                    <span class="badge bg-{{ $cirugia->prioridad_color }}">{{ $cirugia->prioridad ?? 'Normal' }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="fas fa-users me-2"></i>Personal e Institución</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="text-muted small">Médico</label>
                                <p class="mb-0 fw-bold">{{ $cirugia->medico->nombre ?? 'No asignado' }}</p>
                            </div>

                            <div class="mb-3">
                                <label class="text-muted small">Instrumentista</label>
                                <p class="mb-0 fw-bold">{{ $cirugia->instrumentista->nombre ?? 'No asignado' }}</p>
                            </div>

                            <div class="mb-3">
                                <label class="text-muted small">Institución</label>
                                <p class="mb-0 fw-bold">{{ $cirugia->institucion->nombre ?? 'No asignada' }}</p>
                            </div>

                            <div class="mb-3">
                                <label class="text-muted small">Equipo</label>
                                <p class="mb-0 fw-bold">{{ $cirugia->equipo->nombre ?? 'No asignado' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="fas fa-clipboard me-2"></i>Observaciones</h6>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $cirugia->observaciones ?: 'No hay observaciones registradas.' }}</p>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="fas fa-history me-2"></i>Historial</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="text-muted small">Creado</label>
                            <p class="mb-0">{{ \Carbon\Carbon::parse($cirugia->created_at)->format('d/m/Y H:i') }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">Última actualización</label>
                            <p class="mb-0">{{ \Carbon\Carbon::parse($cirugia->updated_at)->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer d-flex justify-content-between bg-light">
            <div>
                <a href="{{ route('modulo.cirugias.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Volver
                </a>
            </div>
            <div>
                <a href="{{ route('modulo.cirugias.edit', $cirugia->id) }}" class="btn btn-primary me-2">
                    <i class="fas fa-edit me-1"></i>Editar
                </a>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                    <i class="fas fa-trash-alt me-1"></i>Eliminar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de eliminación -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">Confirmar eliminación</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que deseas eliminar esta cirugía? Esta acción no se puede deshacer.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form action="{{ route('modulo.cirugias.destroy', $cirugia->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

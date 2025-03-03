@extends('cirugias::layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Encabezado y Estadísticas -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="mb-3">Kanban de Cirugías</h1>
            <!-- Alertas -->
            @foreach($alertas as $alerta)
                <div class="alert alert-{{ $alerta['tipo'] }} alert-dismissible fade show" role="alert">
                    <i class="fas fa-info-circle me-2"></i>
                    {{ $alerta['mensaje'] }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endforeach
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">
                        <i class="fas fa-chart-bar me-2 text-primary"></i>
                        Estadísticas
                    </h5>
                    <div class="row">
                        <div class="col-6 mb-2">
                            <small class="text-muted">Total Cirugías:</small>
                            <h4 class="mb-0">{{ $stats['total'] }}</h4>
                        </div>
                        <div class="col-6 mb-2">
                            <small class="text-muted">Hoy:</small>
                            <h4 class="mb-0">{{ $stats['hoy'] }}</h4>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">En Proceso:</small>
                            <h4 class="mb-0 text-warning">{{ $stats['en_proceso'] }}</h4>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Esta Semana:</small>
                            <h4 class="mb-0">{{ $stats['semana'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tablero Kanban -->
    <div class="row">
        <!-- Columna Pendientes -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-header" style="background-color: #0F3061;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-white">Pendientes</h5>
                        <span class="badge bg-light text-dark">{{ count($cirugias['pendiente']) }}</span>
                    </div>
                </div>
                <div class="card-body kanban-column">
                    @forelse($cirugias['pendiente'] as $cirugia)
                        <div class="card mb-2 kanban-item" data-id="{{ $cirugia->id }}">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="card-title mb-0">{{ $cirugia->institucion->nombre }}</h6>
                                    <div class="dropdown">
                                        <button class="btn btn-link btn-sm p-0 text-muted" data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('cirugias.edit', $cirugia) }}">
                                                    <i class="fas fa-edit me-2"></i>Editar
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item text-success estado-link"
                                                   href="#"
                                                   data-cirugia-id="{{ $cirugia->id }}"
                                                   data-estado="programada">
                                                    <i class="fas fa-calendar-check me-2"></i>Marcar como Programada
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-text">
                                    <p class="mb-1">
                                        <i class="fas fa-calendar text-primary me-2"></i>
                                        {{ $cirugia->fecha->format('d/m/Y') }}
                                    </p>
                                    <p class="mb-1">
                                        <i class="fas fa-clock text-primary me-2"></i>
                                        {{ $cirugia->hora->format('H:i') }}
                                    </p>
                                    <p class="mb-1">
                                        <i class="fas fa-user-md text-primary me-2"></i>
                                        {{ $cirugia->medico->nombre }}
                                    </p>
                                    <p class="mb-0">
                                        <i class="fas fa-user text-primary me-2"></i>
                                        {{ $cirugia->instrumentista->nombre }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted text-center my-3">No hay cirugías pendientes</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Columna Programadas -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-header" style="background-color: #0097CD;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-white">Programadas</h5>
                        <span class="badge bg-light text-dark">{{ count($cirugias['programada']) }}</span>
                    </div>
                </div>
                <div class="card-body kanban-column">
                    @forelse($cirugias['programada'] as $cirugia)
                        <div class="card mb-2 kanban-item" data-id="{{ $cirugia->id }}">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="card-title mb-0">{{ $cirugia->institucion->nombre }}</h6>
                                    <div class="dropdown">
                                        <button class="btn btn-link btn-sm p-0 text-muted" data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('cirugias.edit', $cirugia) }}">
                                                    <i class="fas fa-edit me-2"></i>Editar
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item text-warning estado-link"
                                                   href="#"
                                                   data-cirugia-id="{{ $cirugia->id }}"
                                                   data-estado="en proceso">
                                                    <i class="fas fa-play me-2"></i>Iniciar Cirugía
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-text">
                                    <p class="mb-1">
                                        <i class="fas fa-calendar text-primary me-2"></i>
                                        {{ $cirugia->fecha->format('d/m/Y') }}
                                    </p>
                                    <p class="mb-1">
                                        <i class="fas fa-clock text-primary me-2"></i>
                                        {{ $cirugia->hora->format('H:i') }}
                                    </p>
                                    <p class="mb-1">
                                        <i class="fas fa-user-md text-primary me-2"></i>
                                        {{ $cirugia->medico->nombre }}
                                    </p>
                                    <p class="mb-0">
                                        <i class="fas fa-user text-primary me-2"></i>
                                        {{ $cirugia->instrumentista->nombre }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted text-center my-3">No hay cirugías programadas</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Columna En Proceso -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-header" style="background-color: #65D7CA;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-white">En Proceso</h5>
                        <span class="badge bg-light text-dark">{{ count($cirugias['en proceso']) }}</span>
                    </div>
                </div>
                <div class="card-body kanban-column">
                    @forelse($cirugias['en proceso'] as $cirugia)
                        <div class="card mb-2 kanban-item" data-id="{{ $cirugia->id }}">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="card-title mb-0">{{ $cirugia->institucion->nombre }}</h6>
                                    <div class="dropdown">
                                        <button class="btn btn-link btn-sm p-0 text-muted" data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('cirugias.edit', $cirugia) }}">
                                                    <i class="fas fa-edit me-2"></i>Editar
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item text-success estado-link"
                                                   href="#"
                                                   data-cirugia-id="{{ $cirugia->id }}"
                                                   data-estado="finalizada">
                                                    <i class="fas fa-check me-2"></i>Finalizar Cirugía
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-text">
                                    <p class="mb-1">
                                        <i class="fas fa-calendar text-primary me-2"></i>
                                        {{ $cirugia->fecha->format('d/m/Y') }}
                                    </p>
                                    <p class="mb-1">
                                        <i class="fas fa-clock text-primary me-2"></i>
                                        {{ $cirugia->hora->format('H:i') }}
                                    </p>
                                    <p class="mb-1">
                                        <i class="fas fa-user-md text-primary me-2"></i>
                                        {{ $cirugia->medico->nombre }}
                                    </p>
                                    <p class="mb-0">
                                        <i class="fas fa-user text-primary me-2"></i>
                                        {{ $cirugia->instrumentista->nombre }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted text-center my-3">No hay cirugías en proceso</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Columna Finalizadas -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-header" style="background-color: #AAE9E2;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-dark">Finalizadas</h5>
                        <span class="badge bg-dark">{{ count($cirugias['finalizada']) }}</span>
                    </div>
                </div>
                <div class="card-body kanban-column">
                    @forelse($cirugias['finalizada'] as $cirugia)
                        <div class="card mb-2 kanban-item" data-id="{{ $cirugia->id }}">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="card-title mb-0">{{ $cirugia->institucion->nombre }}</h6>
                                    <div class="dropdown">
                                        <button class="btn btn-link btn-sm p-0 text-muted" data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('cirugias.edit', $cirugia) }}">
                                                    <i class="fas fa-edit me-2"></i>Ver Detalles
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-text">
                                    <p class="mb-1">
                                        <i class="fas fa-calendar text-primary me-2"></i>
                                        {{ $cirugia->fecha->format('d/m/Y') }}
                                    </p>
                                    <p class="mb-1">
                                        <i class="fas fa-clock text-primary me-2"></i>
                                        {{ $cirugia->hora->format('H:i') }}
                                    </p>
                                    <p class="mb-1">
                                        <i class="fas fa-user-md text-primary me-2"></i>
                                        {{ $cirugia->medico->nombre }}
                                    </p>
                                    <p class="mb-0">
                                        <i class="fas fa-user text-primary me-2"></i>
                                        {{ $cirugia->instrumentista->nombre }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted text-center my-3">No hay cirugías finalizadas</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.kanban-column {
    min-height: calc(100vh - 250px);
    background-color: #f8f9fa;
    border-radius: 0 0 4px 4px;
    padding: 15px;
}

.kanban-item {
    cursor: pointer;
    transition: all 0.3s ease;
}

.kanban-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.card-header {
    border-bottom: none;
}

.card-body {
    padding: 1rem;
}

.card-text {
    font-size: 0.9rem;
    margin-bottom: 0;
}

.card-text p {
    margin-bottom: 0.5rem;
}

.card-text i {
    width: 20px;
    text-align: center;
}

.text-primary {
    color: #0F3061 !important;
}

.dropdown-item:hover {
    background-color: #f8f9fa;
}

.dropdown-item i {
    width: 20px;
    text-align: center;
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Manejar cambios de estado
    document.querySelectorAll('.estado-link').forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();

            const cirugiaId = this.dataset.cirugiaId;
            const nuevoEstado = this.dataset.estado;

            if (confirm('¿Está seguro de que desea cambiar el estado de esta cirugía?')) {
                fetch(`/cirugias/${cirugiaId}/estado`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        estado: nuevoEstado
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Ocurrió un error al actualizar el estado');
                });
            }
        });
    });
});
</script>
@endpush
@endsection

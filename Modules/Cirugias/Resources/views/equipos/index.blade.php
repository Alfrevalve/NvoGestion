@extends('cirugias::layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h6 class="card-title">Total Equipos</h6>
                    <h2 class="mb-0">{{ $stats['total'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h6 class="card-title">Disponibles</h6>
                    <h2 class="mb-0">{{ $stats['disponibles'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h6 class="card-title">En Uso</h6>
                    <h2 class="mb-0">{{ $stats['en_uso'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card bg-warning">
                <div class="card-body">
                    <h6 class="card-title text-dark">En Mantenimiento</h6>
                    <h2 class="mb-0 text-dark">{{ $stats['mantenimiento'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <h6 class="card-title">Fuera de Servicio</h6>
                    <h2 class="mb-0">{{ $stats['fuera_servicio'] }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Alertas -->
    @foreach($alertas as $alerta)
        <div class="alert alert-{{ $alerta['tipo'] }} alert-dismissible fade show" role="alert">
            <i class="fas fa-info-circle me-2"></i> {{ $alerta['mensaje'] }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endforeach

    <!-- Lista de Equipos -->
    <div class="card shadow">
        <div class="card-header bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-microscope me-2"></i> Gestión de Equipos
                </h5>
                <a href="{{ route('cirugias.equipos.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> Nuevo Equipo
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>Equipo</th>
                            <th>Número Serie</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Próximo Mantenimiento</th>
                            <th class="text-center">Cirugías</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($equipos as $equipo)
                            <tr>
                                <td>
                                    <strong>{{ $equipo->nombre }}</strong>
                                    @if($equipo->descripcion)
                                        <small class="d-block text-muted">{{ $equipo->descripcion }}</small>
                                    @endif
                                </td>
                                <td>{{ $equipo->numero_serie ?: 'N/A' }}</td>
                                <td class="text-center">
                                    <span class="badge"
                                          style="background-color: {{ $equipo::getEstadoColor($equipo->estado) }};
                                                 color: {{ $equipo::getEstadoTextColor($equipo->estado) }}">
                                        <i class="{{ $equipo::getEstadoIcon($equipo->estado) }} me-1"></i>
                                        {{ $equipo::getEstadoOptions()[$equipo->estado] }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if($equipo->fecha_mantenimiento)
                                        @if($equipo->needsMantenimiento())
                                            <span class="badge bg-danger">
                                                <i class="fas fa-exclamation-circle me-1"></i>
                                                Vencido ({{ $equipo->fecha_mantenimiento->format('d/m/Y') }})
                                            </span>
                                        @else
                                            <span class="badge bg-{{ $equipo->getDiasHastaMantenimiento() <= 7 ? 'warning' : 'info' }}">
                                                {{ $equipo->fecha_mantenimiento->format('d/m/Y') }}
                                                <small>({{ $equipo->getDiasHastaMantenimiento() }} días)</small>
                                            </span>
                                        @endif
                                    @else
                                        <span class="text-muted">No programado</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-secondary">
                                        {{ $equipo->cirugias_count }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{ route('cirugias.equipos.edit', $equipo) }}"
                                           class="btn btn-sm btn-info"
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if($equipo->estado !== 'en uso' && $equipo->cirugias_count === 0)
                                            <form action="{{ route('cirugias.equipos.destroy', $equipo) }}"
                                                  method="POST"
                                                  class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-sm btn-danger"
                                                        onclick="return confirm('¿Está seguro que desea eliminar este equipo?')"
                                                        title="Eliminar">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="fas fa-microscope fa-3x text-muted mb-3 d-block"></i>
                                    <p class="text-muted mb-0">No hay equipos registrados</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($equipos->hasPages())
            <div class="card-footer">
                <div class="d-flex justify-content-center">
                    {{ $equipos->links() }}
                </div>
            </div>
        @endif
    </div>
</div>

@push('styles')
<style>
    .card {
        transition: transform 0.2s;
    }
    .card:hover {
        transform: translateY(-2px);
    }
    .badge {
        font-size: 0.875rem;
        padding: 0.5em 0.75em;
    }
    .table td {
        vertical-align: middle;
    }
    .btn-group .btn {
        margin-right: 0.25rem;
    }
    .btn-group .btn:last-child {
        margin-right: 0;
    }
</style>
@endpush
@endsection

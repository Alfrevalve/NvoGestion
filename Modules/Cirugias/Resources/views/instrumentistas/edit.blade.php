@extends('cirugias::layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Editar Instrumentista</h1>
                <a href="{{ route('cirugias.instrumentistas.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Volver
                </a>
            </div>

            <div class="card">
                <div class="card-header" style="background-color: #0F3061; color: white;">
                    <h5 class="mb-0">
                        <i class="fas fa-user me-2"></i>
                        {{ $instrumentista->nombre }}
                    </h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('cirugias.instrumentistas.update', $instrumentista) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="nombre" class="form-label">
                                <i class="fas fa-user me-2 text-primary"></i>Nombre Completo
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   class="form-control @error('nombre') is-invalid @enderror"
                                   id="nombre"
                                   name="nombre"
                                   value="{{ old('nombre', $instrumentista->nombre) }}"
                                   required>
                            @error('nombre')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="telefono" class="form-label">
                                <i class="fas fa-phone me-2 text-primary"></i>Teléfono
                            </label>
                            <input type="text"
                                   class="form-control @error('telefono') is-invalid @enderror"
                                   id="telefono"
                                   name="telefono"
                                   value="{{ old('telefono', $instrumentista->telefono) }}">
                            @error('telefono')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="disponibilidad" class="form-label">
                                <i class="fas fa-clock me-2 text-primary"></i>Disponibilidad
                            </label>
                            <select class="form-select @error('disponibilidad') is-invalid @enderror"
                                    id="disponibilidad"
                                    name="disponibilidad">
                                <option value="">Seleccione la disponibilidad</option>
                                <option value="mañana" {{ old('disponibilidad', $instrumentista->disponibilidad) == 'mañana' ? 'selected' : '' }}>Mañana</option>
                                <option value="tarde" {{ old('disponibilidad', $instrumentista->disponibilidad) == 'tarde' ? 'selected' : '' }}>Tarde</option>
                                <option value="noche" {{ old('disponibilidad', $instrumentista->disponibilidad) == 'noche' ? 'selected' : '' }}>Noche</option>
                                <option value="24h" {{ old('disponibilidad', $instrumentista->disponibilidad) == '24h' ? 'selected' : '' }}>24 horas</option>
                            </select>
                            @error('disponibilidad')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="observaciones" class="form-label">
                                <i class="fas fa-sticky-note me-2 text-primary"></i>Observaciones
                            </label>
                            <textarea class="form-control @error('observaciones') is-invalid @enderror"
                                      id="observaciones"
                                      name="observaciones"
                                      rows="3">{{ old('observaciones', $instrumentista->observaciones) }}</textarea>
                            @error('observaciones')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('cirugias.instrumentistas.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Actualizar
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Cirugías Recientes -->
            <div class="card mt-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-calendar-alt me-2"></i>
                        Cirugías Recientes
                    </h5>
                </div>
                <div class="card-body">
                    @if($instrumentista->cirugias->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Institución</th>
                                        <th>Médico</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($instrumentista->cirugias as $cirugia)
                                        <tr>
                                            <td>{{ $cirugia->fecha->format('d/m/Y H:i') }}</td>
                                            <td>{{ $cirugia->institucion->nombre }}</td>
                                            <td>{{ $cirugia->medico->nombre }}</td>
                                            <td>
                                                <span class="badge bg-{{ $cirugia->estado === 'finalizada' ? 'success' : 'primary' }}">
                                                    {{ ucfirst($cirugia->estado) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted mb-0">
                            <i class="fas fa-info-circle me-1"></i>
                            Este instrumentista aún no ha participado en cirugías
                        </p>
                    @endif
                </div>
            </div>

            <!-- Zona de Peligro -->
            @if($instrumentista->cirugias->count() == 0)
                <div class="card mt-4">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Zona de Peligro
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('cirugias.instrumentistas.destroy', $instrumentista) }}"
                              method="POST"
                              onsubmit="return confirm('¿Está seguro de que desea eliminar este instrumentista? Esta acción no se puede deshacer.');">
                            @csrf
                            @method('DELETE')
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">Eliminar Instrumentista</h6>
                                    <p class="text-muted mb-0">Esta acción no se puede deshacer</p>
                                </div>
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash me-2"></i>Eliminar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.form-label {
    font-weight: 500;
}

.form-control:focus, .form-select:focus {
    border-color: #0F3061;
    box-shadow: 0 0 0 0.2rem rgba(15, 48, 97, 0.25);
}

.btn-primary {
    background-color: #0F3061;
    border-color: #0F3061;
}

.btn-primary:hover {
    background-color: #0097CD;
    border-color: #0097CD;
}

.text-primary {
    color: #0F3061 !important;
}

.card-header h5 {
    margin: 0;
    font-size: 1.1rem;
}

.table td {
    vertical-align: middle;
}

.badge {
    font-weight: 500;
    padding: 0.5em 0.8em;
}

.bg-info {
    background-color: #0097CD !important;
}
</style>
@endsection

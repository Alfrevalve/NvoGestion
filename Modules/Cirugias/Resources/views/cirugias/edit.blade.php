@extends('cirugias::layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Editar Cirugía</h1>
                <a href="{{ route('cirugias.kanban') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Volver al Kanban
                </a>
            </div>

            <div class="card">
                <div class="card-header" style="background-color: #0F3061; color: white;">
                    <h5 class="mb-0">
                        <i class="fas fa-edit me-2"></i>
                        Editar Cirugía #{{ $cirugia->id }}
                    </h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('cirugias.update', $cirugia) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Información Principal -->
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="fecha" class="form-label">
                                    <i class="fas fa-calendar me-2 text-primary"></i>Fecha
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="date"
                                       class="form-control @error('fecha') is-invalid @enderror"
                                       id="fecha"
                                       name="fecha"
                                       value="{{ old('fecha', $cirugia->fecha->format('Y-m-d')) }}"
                                       required>
                                @error('fecha')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="hora" class="form-label">
                                    <i class="fas fa-clock me-2 text-primary"></i>Hora
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="time"
                                       class="form-control @error('hora') is-invalid @enderror"
                                       id="hora"
                                       name="hora"
                                       value="{{ old('hora', $cirugia->hora->format('H:i')) }}"
                                       required>
                                @error('hora')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Tipo y Prioridad -->
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="tipo_cirugia" class="form-label">
                                    <i class="fas fa-tag me-2 text-primary"></i>Tipo de Cirugía
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       class="form-control @error('tipo_cirugia') is-invalid @enderror"
                                       id="tipo_cirugia"
                                       name="tipo_cirugia"
                                       value="{{ old('tipo_cirugia', $cirugia->tipo_cirugia) }}"
                                       required>
                                @error('tipo_cirugia')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="prioridad" class="form-label">
                                    <i class="fas fa-exclamation-circle me-2 text-primary"></i>Prioridad
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('prioridad') is-invalid @enderror"
                                        id="prioridad"
                                        name="prioridad"
                                        required>
                                    <option value="">Seleccione la prioridad</option>
                                    <option value="baja" {{ old('prioridad', $cirugia->prioridad) == 'baja' ? 'selected' : '' }}>Baja</option>
                                    <option value="media" {{ old('prioridad', $cirugia->prioridad) == 'media' ? 'selected' : '' }}>Media</option>
                                    <option value="alta" {{ old('prioridad', $cirugia->prioridad) == 'alta' ? 'selected' : '' }}>Alta</option>
                                    <option value="urgente" {{ old('prioridad', $cirugia->prioridad) == 'urgente' ? 'selected' : '' }}>Urgente</option>
                                </select>
                                @error('prioridad')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Personal -->
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <label for="medico_id" class="form-label">
                                    <i class="fas fa-user-md me-2 text-primary"></i>Médico
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('medico_id') is-invalid @enderror"
                                        id="medico_id"
                                        name="medico_id"
                                        required>
                                    <option value="">Seleccione un médico</option>
                                    @foreach($medicos as $medico)
                                        <option value="{{ $medico->id }}" {{ old('medico_id', $cirugia->medico_id) == $medico->id ? 'selected' : '' }}>
                                            {{ $medico->nombre }} - {{ $medico->especialidad }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('medico_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-4">
                                <label for="instrumentista_id" class="form-label">
                                    <i class="fas fa-user me-2 text-primary"></i>Instrumentista
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('instrumentista_id') is-invalid @enderror"
                                        id="instrumentista_id"
                                        name="instrumentista_id"
                                        required>
                                    <option value="">Seleccione un instrumentista</option>
                                    @foreach($instrumentistas as $instrumentista)
                                        <option value="{{ $instrumentista->id }}" {{ old('instrumentista_id', $cirugia->instrumentista_id) == $instrumentista->id ? 'selected' : '' }}>
                                            {{ $instrumentista->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('instrumentista_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-4">
                                <label for="institucion_id" class="form-label">
                                    <i class="fas fa-hospital me-2 text-primary"></i>Institución
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('institucion_id') is-invalid @enderror"
                                        id="institucion_id"
                                        name="institucion_id"
                                        required>
                                    <option value="">Seleccione una institución</option>
                                    @foreach($instituciones as $institucion)
                                        <option value="{{ $institucion->id }}" {{ old('institucion_id', $cirugia->institucion_id) == $institucion->id ? 'selected' : '' }}>
                                            {{ $institucion->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('institucion_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Equipamiento y Material -->
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="equipo_id" class="form-label">
                                    <i class="fas fa-tools me-2 text-primary"></i>Equipo
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('equipo_id') is-invalid @enderror"
                                        id="equipo_id"
                                        name="equipo_id"
                                        required>
                                    <option value="">Seleccione un equipo</option>
                                    @foreach($equipos as $equipo)
                                        <option value="{{ $equipo->id }}"
                                                {{ old('equipo_id', $cirugia->equipo_id) == $equipo->id ? 'selected' : '' }}
                                                {{ $equipo->estado !== 'disponible' && $equipo->id !== $cirugia->equipo_id ? 'disabled' : '' }}>
                                            {{ $equipo->nombre }}
                                            @if($equipo->estado !== 'disponible' && $equipo->id !== $cirugia->equipo_id)
                                                ({{ ucfirst($equipo->estado) }})
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('equipo_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="material_id" class="form-label">
                                    <i class="fas fa-box me-2 text-primary"></i>Material
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('material_id') is-invalid @enderror"
                                        id="material_id"
                                        name="material_id"
                                        required>
                                    <option value="">Seleccione un material</option>
                                    @foreach($materiales as $material)
                                        <option value="{{ $material->id }}" {{ old('material_id', $cirugia->material_id) == $material->id ? 'selected' : '' }}>
                                            {{ $material->nombre }} (Stock: {{ $material->cantidad }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('material_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Duración y Estado -->
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="duracion_estimada" class="form-label">
                                    <i class="fas fa-hourglass-half me-2 text-primary"></i>Duración Estimada (minutos)
                                </label>
                                <input type="number"
                                       class="form-control @error('duracion_estimada') is-invalid @enderror"
                                       id="duracion_estimada"
                                       name="duracion_estimada"
                                       value="{{ old('duracion_estimada', $cirugia->duracion_estimada) }}"
                                       min="1">
                                @error('duracion_estimada')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="estado" class="form-label">
                                    <i class="fas fa-info-circle me-2 text-primary"></i>Estado
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('estado') is-invalid @enderror"
                                        id="estado"
                                        name="estado"
                                        required>
                                    <option value="">Seleccione un estado</option>
                                    <option value="pendiente" {{ old('estado', $cirugia->estado) == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="programada" {{ old('estado', $cirugia->estado) == 'programada' ? 'selected' : '' }}>Programada</option>
                                    <option value="en proceso" {{ old('estado', $cirugia->estado) == 'en proceso' ? 'selected' : '' }}>En Proceso</option>
                                    <option value="finalizada" {{ old('estado', $cirugia->estado) == 'finalizada' ? 'selected' : '' }}>Finalizada</option>
                                </select>
                                @error('estado')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Observaciones -->
                        <div class="mb-4">
                            <label for="observaciones" class="form-label">
                                <i class="fas fa-sticky-note me-2 text-primary"></i>Observaciones
                            </label>
                            <textarea class="form-control @error('observaciones') is-invalid @enderror"
                                      id="observaciones"
                                      name="observaciones"
                                      rows="3">{{ old('observaciones', $cirugia->observaciones) }}</textarea>
                            @error('observaciones')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('cirugias.kanban') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Actualizar
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Zona de Peligro -->
            <div class="card mt-4">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Zona de Peligro
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('cirugias.destroy', $cirugia) }}"
                          method="POST"
                          onsubmit="return confirm('¿Está seguro de que desea eliminar esta cirugía? Esta acción no se puede deshacer.');">
                        @csrf
                        @method('DELETE')
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">Eliminar Cirugía</h6>
                                <p class="text-muted mb-0">Esta acción no se puede deshacer</p>
                            </div>
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash me-2"></i>Eliminar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
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

input[type="number"] {
    -moz-appearance: textfield;
}

input[type="number"]::-webkit-outer-spin-button,
input[type="number"]::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validación de estado según equipo
    const equipoSelect = document.getElementById('equipo_id');
    const estadoSelect = document.getElementById('estado');
    const estadoOriginal = '{{ $cirugia->estado }}';
    const equipoOriginal = '{{ $cirugia->equipo_id }}';

    equipoSelect.addEventListener('change', function() {
        if (this.value !== equipoOriginal && estadoSelect.value === 'en proceso') {
            alert('No se puede cambiar el equipo mientras la cirugía está en proceso');
            this.value = equipoOriginal;
        }
    });

    estadoSelect.addEventListener('change', function() {
        if (this.value === 'en proceso' && equipoSelect.value !== equipoOriginal) {
            alert('No se puede poner en proceso la cirugía con un equipo diferente');
            this.value = estadoOriginal;
        }
    });
});
</script>
@endpush
@endsection

@extends('cirugias::layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Editar Médico</h1>
                <a href="{{ route('cirugias.medicos.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Volver
                </a>
            </div>

            <div class="card">
                <div class="card-header" style="background-color: #0F3061; color: white;">
                    <h5 class="mb-0">
                        <i class="fas fa-user-md me-2"></i>
                        {{ $medico->nombre }}
                    </h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('cirugias.medicos.update', $medico) }}" method="POST">
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
                                   value="{{ old('nombre', $medico->nombre) }}"
                                   required>
                            @error('nombre')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="especialidad" class="form-label">
                                <i class="fas fa-stethoscope me-2 text-primary"></i>Especialidad
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   class="form-control @error('especialidad') is-invalid @enderror"
                                   id="especialidad"
                                   name="especialidad"
                                   value="{{ old('especialidad', $medico->especialidad) }}"
                                   required>
                            @error('especialidad')
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
                                   value="{{ old('telefono', $medico->telefono) }}">
                            @error('telefono')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Este campo es opcional
                            </small>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('cirugias.medicos.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Actualizar
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Información de Cirugías -->
            <div class="card mt-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-calendar-alt me-2"></i>
                        Cirugías Programadas
                    </h5>
                </div>
                <div class="card-body">
                    @if($medico->cirugias->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Institución</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($medico->cirugias as $cirugia)
                                        <tr>
                                            <td>{{ $cirugia->fecha->format('d/m/Y H:i') }}</td>
                                            <td>{{ $cirugia->institucion->nombre }}</td>
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
                            Este médico aún no tiene cirugías programadas
                        </p>
                    @endif
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
                    <form action="{{ route('cirugias.medicos.destroy', $medico) }}"
                          method="POST"
                          onsubmit="return confirm('¿Está seguro de que desea eliminar este médico? Esta acción no se puede deshacer.');">
                        @csrf
                        @method('DELETE')
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">Eliminar Médico</h6>
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

.form-control:focus {
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

.text-muted {
    font-size: 0.875rem;
}

.table td {
    vertical-align: middle;
}

.badge {
    font-weight: 500;
    padding: 0.5em 0.8em;
}
</style>
@endsection

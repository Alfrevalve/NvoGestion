@extends('cirugias::layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Editar Institución</h1>
                <a href="{{ route('cirugias.instituciones.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Volver
                </a>
            </div>

            <div class="card">
                <div class="card-header" style="background-color: #0F3061; color: white;">
                    <h5 class="mb-0">
                        <i class="fas fa-hospital me-2"></i>
                        {{ $institucion->nombre }}
                    </h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('cirugias.instituciones.update', $institucion->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="nombre" class="form-label">
                                <i class="fas fa-hospital me-2 text-primary"></i>Nombre
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   class="form-control @error('nombre') is-invalid @enderror"
                                   id="nombre"
                                   name="nombre"
                                   value="{{ old('nombre', $institucion->nombre) }}"
                                   required>
                            @error('nombre')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="direccion" class="form-label">
                                <i class="fas fa-map-marker-alt me-2 text-primary"></i>Dirección
                            </label>
                            <input type="text"
                                   class="form-control @error('direccion') is-invalid @enderror"
                                   id="direccion"
                                   name="direccion"
                                   value="{{ old('direccion', $institucion->direccion) }}">
                            @error('direccion')
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
                                   value="{{ old('telefono', $institucion->telefono) }}">
                            @error('telefono')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('cirugias.instituciones.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Actualizar
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Estadísticas -->
            <div class="card mt-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-bar me-2"></i>
                        Estadísticas
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-4">
                            <h6 class="text-muted mb-2">Total Cirugías</h6>
                            <h3>{{ $institucion->cirugias_count }}</h3>
                        </div>
                        <div class="col-md-4">
                            <h6 class="text-muted mb-2">Pendientes</h6>
                            <h3>{{ $institucion->pending_cirugias_count }}</h3>
                        </div>
                        <div class="col-md-4">
                            <h6 class="text-muted mb-2">Activas</h6>
                            <h3>{{ $institucion->active_cirugias_count }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Zona de Peligro -->
            @if($institucion->cirugias_count == 0)
                <div class="card mt-4">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Zona de Peligro
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('cirugias.instituciones.destroy', $institucion->id) }}"
                              method="POST"
                              onsubmit="return confirm('¿Está seguro de que desea eliminar esta institución? Esta acción no se puede deshacer.');">
                            @csrf
                            @method('DELETE')
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">Eliminar Institución</h6>
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

.bg-info {
    background-color: #0097CD !important;
}
</style>
@endsection

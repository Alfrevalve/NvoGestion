@extends('cirugias::layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Nuevo Instrumentista</h1>
                <a href="{{ route('cirugias.instrumentistas.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Volver
                </a>
            </div>

            <div class="card">
                <div class="card-header" style="background-color: #0F3061; color: white;">
                    <h5 class="mb-0">
                        <i class="fas fa-user me-2"></i>
                        Información del Instrumentista
                    </h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('cirugias.instrumentistas.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="nombre" class="form-label">
                                <i class="fas fa-user me-2 text-primary"></i>Nombre Completo
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   class="form-control @error('nombre') is-invalid @enderror"
                                   id="nombre"
                                   name="nombre"
                                   value="{{ old('nombre') }}"
                                   required
                                   autofocus
                                   placeholder="Ej: María García">
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
                                   value="{{ old('telefono') }}"
                                   placeholder="Ej: +54 11 1234-5678">
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
                                <option value="mañana" {{ old('disponibilidad') == 'mañana' ? 'selected' : '' }}>Mañana</option>
                                <option value="tarde" {{ old('disponibilidad') == 'tarde' ? 'selected' : '' }}>Tarde</option>
                                <option value="noche" {{ old('disponibilidad') == 'noche' ? 'selected' : '' }}>Noche</option>
                                <option value="24h" {{ old('disponibilidad') == '24h' ? 'selected' : '' }}>24 horas</option>
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
                                      rows="3"
                                      placeholder="Agregue cualquier información adicional relevante">{{ old('observaciones') }}</textarea>
                            @error('observaciones')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <button type="reset" class="btn btn-secondary">
                                <i class="fas fa-undo me-2"></i>Restablecer
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Guardar
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

.form-select {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 0.75rem center;
    background-size: 16px 12px;
}
</style>
@endsection

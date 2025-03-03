@extends('cirugias::layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Nuevo Médico</h1>
                <a href="{{ route('cirugias.medicos.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Volver
                </a>
            </div>

            <div class="card">
                <div class="card-header" style="background-color: #0F3061; color: white;">
                    <h5 class="mb-0">
                        <i class="fas fa-user-md me-2"></i>
                        Información del Médico
                    </h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('cirugias.medicos.store') }}" method="POST">
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
                                   placeholder="Ej: Dr. Juan Pérez">
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
                                   value="{{ old('especialidad') }}"
                                   required
                                   placeholder="Ej: Cirujano General">
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
                                   value="{{ old('telefono') }}"
                                   placeholder="Ej: +54 11 1234-5678">
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
</style>
@endsection

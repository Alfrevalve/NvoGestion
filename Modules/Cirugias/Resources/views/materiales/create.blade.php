@extends('cirugias::layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Nuevo Material</h1>
                <a href="{{ route('cirugias.materiales.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Volver
                </a>
            </div>

            <div class="card">
                <div class="card-header" style="background-color: #0F3061; color: white;">
                    <h5 class="mb-0">
                        <i class="fas fa-box me-2"></i>
                        Información del Material
                    </h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('cirugias.materiales.store') }}" method="POST">
                        @csrf

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="mb-4">
                            <label for="nombre" class="form-label">
                                <i class="fas fa-hospital me-2 text-primary"></i>Nombre
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   class="form-control @error('nombre') is-invalid @enderror"
                                   id="nombre"
                                   name="nombre"
                                   value="{{ old('nombre') }}"
                                   required
                                   autofocus
                                   placeholder="Ej: Sutura quirúrgica">
                            @error('nombre')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="codigo" class="form-label">
                                <i class="fas fa-barcode me-2 text-primary"></i>Código
                            </label>
                            <input type="text"
                                   class="form-control @error('codigo') is-invalid @enderror"
                                   id="codigo"
                                   name="codigo"
                                   value="{{ old('codigo') }}"
                                   placeholder="Ej: MAT-001">
                            @error('codigo')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="cantidad" class="form-label">
                                <i class="fas fa-cubes me-2 text-primary"></i>Cantidad
                            </label>
                            <input type="number"
                                   class="form-control @error('cantidad') is-invalid @enderror"
                                   id="cantidad"
                                   name="cantidad"
                                   value="{{ old('cantidad') }}"
                                   min="0"
                                   placeholder="0">
                            @error('cantidad')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="cantidad_minima" class="form-label">
                                <i class="fas fa-exclamation-triangle me-2 text-primary"></i>Cantidad Mínima
                            </label>
                            <input type="number"
                                   class="form-control @error('cantidad_minima') is-invalid @enderror"
                                   id="cantidad_minima"
                                   name="cantidad_minima"
                                   value="{{ old('cantidad_minima') }}"
                                   min="0"
                                   placeholder="0">
                            @error('cantidad_minima')
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
</style>
@endsection

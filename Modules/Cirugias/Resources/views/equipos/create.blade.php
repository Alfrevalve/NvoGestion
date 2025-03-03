@extends('cirugias::layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="fas fa-microscope me-2"></i> Nuevo Equipo
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('cirugias.equipos.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <!-- Nombre -->
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre del Equipo <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('nombre') is-invalid @enderror"
                                   id="nombre"
                                   name="nombre"
                                   value="{{ old('nombre') }}"
                                   required>
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Estado -->
                        <div class="mb-3">
                            <label for="estado" class="form-label">Estado <span class="text-danger">*</span></label>
                            <select class="form-select @error('estado') is-invalid @enderror"
                                    id="estado"
                                    name="estado"
                                    required>
                                <option value="">Seleccione un estado</option>
                                @foreach($estadoOptions as $value => $label)
                                    <option value="{{ $value }}"
                                            {{ old('estado') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('estado')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Número de Serie -->
                        <div class="mb-3">
                            <label for="numero_serie" class="form-label">Número de Serie</label>
                            <input type="text"
                                   class="form-control @error('numero_serie') is-invalid @enderror"
                                   id="numero_serie"
                                   name="numero_serie"
                                   value="{{ old('numero_serie') }}">
                            @error('numero_serie')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <!-- Fecha de Adquisición -->
                        <div class="mb-3">
                            <label for="fecha_adquisicion" class="form-label">Fecha de Adquisición</label>
                            <input type="date"
                                   class="form-control @error('fecha_adquisicion') is-invalid @enderror"
                                   id="fecha_adquisicion"
                                   name="fecha_adquisicion"
                                   value="{{ old('fecha_adquisicion') }}">
                            @error('fecha_adquisicion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Fecha de Mantenimiento -->
                        <div class="mb-3">
                            <label for="fecha_mantenimiento" class="form-label">Próximo Mantenimiento</label>
                            <input type="date"
                                   class="form-control @error('fecha_mantenimiento') is-invalid @enderror"
                                   id="fecha_mantenimiento"
                                   name="fecha_mantenimiento"
                                   value="{{ old('fecha_mantenimiento') }}">
                            @error('fecha_mantenimiento')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Descripción -->
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control @error('descripcion') is-invalid @enderror"
                                      id="descripcion"
                                      name="descripcion"
                                      rows="3">{{ old('descripcion') }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('cirugias.equipos.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-1"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Guardar Equipo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const fechaAdquisicion = document.getElementById('fecha_adquisicion');
    const fechaMantenimiento = document.getElementById('fecha_mantenimiento');

    function validarFechas() {
        if (fechaAdquisicion.value && fechaMantenimiento.value) {
            if (fechaMantenimiento.value < fechaAdquisicion.value) {
                fechaMantenimiento.setCustomValidity('La fecha de mantenimiento debe ser posterior o igual a la fecha de adquisición');
            } else {
                fechaMantenimiento.setCustomValidity('');
            }
        }
    }

    fechaAdquisicion.addEventListener('change', validarFechas);
    fechaMantenimiento.addEventListener('change', validarFechas);
});
</script>
@endpush
@endsection

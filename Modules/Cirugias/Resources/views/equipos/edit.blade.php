@extends('cirugias::layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="fas fa-microscope me-2"></i> Editar Equipo
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('cirugias.equipos.update', $equipo) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <!-- Nombre -->
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre del Equipo <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('nombre') is-invalid @enderror"
                                   id="nombre"
                                   name="nombre"
                                   value="{{ old('nombre', $equipo->nombre) }}"
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
                                    required
                                    {{ $equipo->estado === 'en uso' && $equipo->cirugias()->whereIn('estado', ['programada', 'en proceso'])->exists() ? 'disabled' : '' }}>
                                <option value="">Seleccione un estado</option>
                                @foreach($estadoOptions as $value => $label)
                                    <option value="{{ $value }}"
                                            {{ old('estado', $equipo->estado) == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @if($equipo->estado === 'en uso' && $equipo->cirugias()->whereIn('estado', ['programada', 'en proceso'])->exists())
                                <div class="form-text text-warning">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    No se puede cambiar el estado porque el equipo está en uso en cirugías activas.
                                </div>
                            @endif
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
                                   value="{{ old('numero_serie', $equipo->numero_serie) }}">
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
                                   value="{{ old('fecha_adquisicion', $equipo->fecha_adquisicion?->format('Y-m-d')) }}">
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
                                   value="{{ old('fecha_mantenimiento', $equipo->fecha_mantenimiento?->format('Y-m-d')) }}">
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
                                      rows="3">{{ old('descripcion', $equipo->descripcion) }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                @if($equipo->cirugias->isNotEmpty())
                    <div class="card mt-4 mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Últimas Cirugías</h6>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-sm mb-0">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Institución</th>
                                        <th>Médico</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($equipo->cirugias as $cirugia)
                                        <tr>
                                            <td>{{ $cirugia->fecha->format('d/m/Y') }}</td>
                                            <td>{{ $cirugia->institucion->nombre }}</td>
                                            <td>{{ $cirugia->medico->nombre }}</td>
                                            <td>
                                                <span class="badge bg-{{ $cirugia->estado === 'programada' ? 'info' : ($cirugia->estado === 'en proceso' ? 'warning' : 'success') }}">
                                                    {{ ucfirst($cirugia->estado) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('cirugias.equipos.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-1"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Actualizar Equipo
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

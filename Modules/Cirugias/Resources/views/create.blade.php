@extends('adminlte::page')

@section('title', isset($cirugia) ? 'Editar Cirugía' : 'Nueva Cirugía')

@section('content_header')
    <h1>{{ isset($cirugia) ? 'Editar Cirugía' : 'Nueva Cirugía' }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">{{ isset($cirugia) ? 'Editar Cirugía #' . $cirugia->id : 'Datos de la Cirugía' }}</h3>
                </div>

                <form method="POST" action="{{ isset($cirugia) ? route('modulo.cirugias.update', $cirugia) : route('modulo.cirugias.store') }}">
                    @csrf
                    @if(isset($cirugia))
                        @method('PUT')
                    @endif

                    <div class="card-body">
                        <div class="row">
                            <!-- Fecha y Hora -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha">Fecha <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('fecha') is-invalid @enderror"
                                           id="fecha" name="fecha"
                                           value="{{ old('fecha', isset($cirugia) ? $cirugia->fecha->format('Y-m-d') : '') }}" required>
                                    @error('fecha')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hora">Hora <span class="text-danger">*</span></label>
                                    <input type="time" class="form-control @error('hora') is-invalid @enderror"
                                           id="hora" name="hora"
                                           value="{{ old('hora', isset($cirugia) ? $cirugia->hora->format('H:i') : '') }}" required>
                                    @error('hora')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Institución y Médico -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="institucion_id">Institución <span class="text-danger">*</span></label>
                                    <select class="form-control @error('institucion_id') is-invalid @enderror"
                                            id="institucion_id" name="institucion_id" required>
                                        <option value="">Seleccione una institución</option>
                                        @foreach($instituciones as $institucion)
                                            <option value="{{ $institucion->id }}"
                                                {{ old('institucion_id', isset($cirugia) ? $cirugia->institucion_id : '') == $institucion->id ? 'selected' : '' }}>
                                                {{ $institucion->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('institucion_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="medico_id">Médico <span class="text-danger">*</span></label>
                                    <select class="form-control @error('medico_id') is-invalid @enderror"
                                            id="medico_id" name="medico_id" required>
                                        <option value="">Seleccione un médico</option>
                                        @foreach($medicos as $medico)
                                            <option value="{{ $medico->id }}"
                                                {{ old('medico_id', isset($cirugia) ? $cirugia->medico_id : '') == $medico->id ? 'selected' : '' }}>
                                                {{ $medico->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('medico_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Instrumentista y Equipo -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="instrumentista_id">Instrumentista <span class="text-danger">*</span></label>
                                    <select class="form-control @error('instrumentista_id') is-invalid @enderror"
                                            id="instrumentista_id" name="instrumentista_id" required>
                                        <option value="">Seleccione un instrumentista</option>
                                        @foreach($instrumentistas as $instrumentista)
                                            <option value="{{ $instrumentista->id }}"
                                                {{ old('instrumentista_id', isset($cirugia) ? $cirugia->instrumentista_id : '') == $instrumentista->id ? 'selected' : '' }}>
                                                {{ $instrumentista->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('instrumentista_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="equipo_id">Equipo <span class="text-danger">*</span></label>
                                    <select class="form-control @error('equipo_id') is-invalid @enderror"
                                            id="equipo_id" name="equipo_id" required>
                                        <option value="">Seleccione un equipo</option>
                                        @foreach($equipos as $equipo)
                                            <option value="{{ $equipo->id }}"
                                                {{ old('equipo_id', isset($cirugia) ? $cirugia->equipo_id : '') == $equipo->id ? 'selected' : '' }}>
                                                {{ $equipo->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('equipo_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Tipo de Cirugía y Estado -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tipo_cirugia">Tipo de Cirugía <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('tipo_cirugia') is-invalid @enderror"
                                           id="tipo_cirugia" name="tipo_cirugia"
                                           value="{{ old('tipo_cirugia', isset($cirugia) ? $cirugia->tipo_cirugia : '') }}" required>
                                    @error('tipo_cirugia')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="estado">Estado <span class="text-danger">*</span></label>
                                    <select class="form-control @error('estado') is-invalid @enderror"
                                            id="estado" name="estado" required>
                                        @foreach(['pendiente', 'programada', 'en proceso', 'finalizada'] as $estado)
                                            <option value="{{ $estado }}"
                                                {{ old('estado', isset($cirugia) ? $cirugia->estado : 'pendiente') == $estado ? 'selected' : '' }}>
                                                {{ ucfirst($estado) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('estado')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Duración Estimada y Prioridad -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="duracion_estimada">Duración Estimada (minutos)</label>
                                    <input type="number" class="form-control @error('duracion_estimada') is-invalid @enderror"
                                           id="duracion_estimada" name="duracion_estimada"
                                           value="{{ old('duracion_estimada', isset($cirugia) ? $cirugia->duracion_estimada : '') }}">
                                    @error('duracion_estimada')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="prioridad">Prioridad <span class="text-danger">*</span></label>
                                    <select class="form-control @error('prioridad') is-invalid @enderror"
                                            id="prioridad" name="prioridad" required>
                                        @foreach(['baja', 'media', 'alta', 'urgente'] as $prioridad)
                                            <option value="{{ $prioridad }}"
                                                {{ old('prioridad', isset($cirugia) ? $cirugia->prioridad : 'media') == $prioridad ? 'selected' : '' }}>
                                                {{ ucfirst($prioridad) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('prioridad')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Observaciones -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="observaciones">Observaciones</label>
                                    <textarea class="form-control @error('observaciones') is-invalid @enderror"
                                              id="observaciones" name="observaciones" rows="3">{{ old('observaciones', isset($cirugia) ? $cirugia->observaciones : '') }}</textarea>
                                    @error('observaciones')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> {{ isset($cirugia) ? 'Actualizar' : 'Guardar' }}
                        </button>
                        <a href="{{ route('modulo.cirugias.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        $(document).ready(function() {
            // Aquí puedes agregar JavaScript personalizado
            // Por ejemplo, para inicializar select2 u otros plugins
        });
    </script>
@stop

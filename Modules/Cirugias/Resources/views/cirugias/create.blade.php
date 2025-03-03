@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Cirugía</h1>
    <form action="{{ route('cirugias.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="institucion_id">Institución</label>
            <select name="institucion_id" id="institucion_id" class="form-control" required>
                <option value="">Seleccione una institución</option>
                @foreach($instituciones as $institucion)
                    <option value="{{ $institucion->id }}">{{ $institucion->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="medico_id">Médico</label>
            <select name="medico_id" id="medico_id" class="form-control" required>
                <option value="">Seleccione un médico</option>
                @foreach($medicos as $medico)
                    <option value="{{ $medico->id }}">{{ $medico->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="instrumentista_id">Instrumentista</label>
            <select name="instrumentista_id" id="instrumentista_id" class="form-control" required>
                <option value="">Seleccione un instrumentista</option>
                @foreach($instrumentistas as $instrumentista)
                    <option value="{{ $instrumentista->id }}">{{ $instrumentista->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="equipo_id">Equipo</label>
            <select name="equipo_id" id="equipo_id" class="form-control" required>
                <option value="">Seleccione un equipo</option>
                @foreach($equipos as $equipo)
                    <option value="{{ $equipo->id }}">{{ $equipo->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="material_id">Material</label>
            <select name="material_id" id="material_id" class="form-control" required>
                <option value="">Seleccione un material</option>
                @foreach($materiales as $material)
                    <option value="{{ $material->id }}">{{ $material->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="fecha">Fecha</label>
            <input type="date" name="fecha" id="fecha" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="hora">Hora</label>
            <input type="time" name="hora" id="hora" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="estado">Estado</label>
            <select name="estado" id="estado" class="form-control" required>
                <option value="pendiente">Pendiente</option>
                <option value="programada">Programada</option>
                <option value="en proceso">En Proceso</option>
                <option value="finalizada">Finalizada</option>
            </select>
        </div>
        <div class="form-group">
            <label for="observaciones">Observaciones</label>
            <textarea name="observaciones" id="observaciones" class="form-control" rows="3"></textarea>
        </div>
        <div class="form-group">
            <label for="duracion_estimada">Duración Estimada (minutos)</label>
            <input type="number" name="duracion_estimada" id="duracion_estimada" class="form-control" min="1">
        </div>
        <div class="form-group">
            <label for="tipo_cirugia">Tipo de Cirugía</label>
            <input type="text" name="tipo_cirugia" id="tipo_cirugia" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="prioridad">Prioridad</label>
            <select name="prioridad" id="prioridad" class="form-control" required>
                <option value="baja">Baja</option>
                <option value="media">Media</option>
                <option value="alta">Alta</option>
                <option value="urgente">Urgente</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Crear Cirugía</button>
    </form>
</div>
@endsection

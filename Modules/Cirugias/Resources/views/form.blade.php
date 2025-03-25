@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Registrar Cirugía</h1>
    <form action="{{ route('modulo.cirugias.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="institucion_id">Institución</label>
            <input type="text" class="form-control" id="institucion_id" name="institucion_id" required>
        </div>
        <div class="form-group">
            <label for="medico_id">Médico</label>
            <input type="text" class="form-control" id="medico_id" name="medico_id" required>
        </div>
        <div class="form-group">
            <label for="instrumentista_id">Instrumentista</label>
            <input type="text" class="form-control" id="instrumentista_id" name="instrumentista_id" required>
        </div>
        <div class="form-group">
            <label for="equipo_id">Equipo</label>
            <input type="text" class="form-control" id="equipo_id" name="equipo_id" required>
        </div>
        <div class="form-group">
            <label for="fecha">Fecha</label>
            <input type="date" class="form-control" id="fecha" name="fecha" required>
        </div>
        <div class="form-group">
            <label for="hora">Hora</label>
            <input type="time" class="form-control" id="hora" name="hora" required>
        </div>
        <div class="form-group">
            <label for="tipo_cirugia">Tipo de Cirugía</label>
            <input type="text" class="form-control" id="tipo_cirugia" name="tipo_cirugia" required>
        </div>
        <div class="form-group">
            <label for="estado">Estado</label>
            <input type="text" class="form-control" id="estado" name="estado" required>
        </div>
        <div class="form-group">
            <label for="prioridad">Prioridad</label>
            <input type="text" class="form-control" id="prioridad" name="prioridad" required>
        </div>
        <div class="form-group">
            <label for="duracion_estimada">Duración Estimada</label>
            <input type="text" class="form-control" id="duracion_estimada" name="duracion_estimada" required>
        </div>
        <div class="form-group">
            <label for="observaciones">Observaciones</label>
            <textarea class="form-control" id="observaciones" name="observaciones"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Registrar Cirugía</button>
    </form>
</div>
@endsection

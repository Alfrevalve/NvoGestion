@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Reporte de Cirugía</h1>
    <form action="{{ route('cirugias.reportes.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="cirugia_id">Cirugía</label>
            <select name="cirugia_id" id="cirugia_id" class="form-control" required>
                <!-- Opciones de cirugías -->
            </select>
        </div>
        <div class="form-group">
            <label for="instrumentista_id">Instrumentista</label>
            <select name="instrumentista_id" id="instrumentista_id" class="form-control" required>
                <!-- Opciones de instrumentistas -->
            </select>
        </div>
        <div class="form-group">
            <label for="medico_id">Médico</label>
            <select name="medico_id" id="medico_id" class="form-control" required>
                <!-- Opciones de médicos -->
            </select>
        </div>
        <div class="form-group">
            <label for="institucion_id">Institución</label>
            <select name="institucion_id" id="institucion_id" class="form-control" required>
                <!-- Opciones de instituciones -->
            </select>
        </div>
        <div class="form-group">
            <label for="sistema">Sistema</label>
            <select name="sistema" id="sistema" class="form-control" required>
                <option value="MR8">MR8</option>
                <option value="SPINE">SPINE</option>
                <option value="HC">HC</option>
                <option value="ULIS">ULIS</option>
                <option value="LUMIS">LUMIS</option>
                <option value="SPINEART">SPINEART</option>
            </select>
        </div>
        <div class="form-group">
            <label for="hoja_consumo">Hoja de Consumo</label>
            <select name="hoja_consumo" id="hoja_consumo" class="form-control" required>
                <option value="Si">Sí</option>
                <option value="No">No</option>
            </select>
        </div>
        <div class="form-group">
            <label for="hora_programada">Hora Programada</label>
            <input type="time" name="hora_programada" id="hora_programada" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="hora_inicio">Hora de Inicio</label>
            <input type="time" name="hora_inicio" id="hora_inicio" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="hora_fin">Hora de Fin</label>
            <input type="time" name="hora_fin" id="hora_fin" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="archivo_hoja_consumo">Archivo Hoja de Consumo</label>
            <input type="file" name="archivo_hoja_consumo" id="archivo_hoja_consumo" class="form-control" accept=".jpg,.jpeg,.png">
        </div>
        <button type="submit" class="btn btn-primary">Crear Reporte</button>
    </form>
</div>
@endsection

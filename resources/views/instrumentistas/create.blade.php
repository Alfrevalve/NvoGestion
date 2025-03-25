@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Nuevo Instrumentista</h1>
    <form action="{{ route('modulo.instrumentistas.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nombre">Nombre del Instrumentista</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input type="text" class="form-control" id="telefono" name="telefono">
        </div>
        <div class="form-group">
            <label for="disponibilidad">Disponibilidad</label>
            <select class="form-control" id="disponibilidad" name="disponibilidad">
                <option value="mañana">Mañana</option>
                <option value="tarde">Tarde</option>
                <option value="noche">Noche</option>
                <option value="24h">24h</option>
            </select>
        </div>
        <div class="form-group">
            <label for="observaciones">Observaciones</label>
            <textarea class="form-control" id="observaciones" name="observaciones"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Crear Instrumentista</button>
    </form>
</div>
@endsection

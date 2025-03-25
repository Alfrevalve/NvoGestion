@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Nuevo Equipo</h1>
    <form action="{{ route('modulo.equipos.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nombre">Nombre del Equipo</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="form-group">
            <label for="estado">Estado</label>
            <select class="form-control" id="estado" name="estado" required>
                <option value="disponible">Disponible</option>
                <option value="en uso">En Uso</option>
                <option value="mantenimiento">Mantenimiento</option>
                <option value="fuera de servicio">Fuera de Servicio</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Crear Equipo</button>
    </form>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Nueva Institución</h1>
    <form action="{{ route('modulo.instituciones.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nombre">Nombre de la Institución</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="form-group">
            <label for="direccion">Dirección</label>
            <input type="text" class="form-control" id="direccion" name="direccion">
        </div>
        <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input type="text" class="form-control" id="telefono" name="telefono">
        </div>
        <button type="submit" class="btn btn-primary">Crear Institución</button>
    </form>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Nueva Cirugía</h1>
    <form action="{{ route('modulo.cirugias.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nombre">Nombre de la Cirugía</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="form-group">
            <label for="fecha">Fecha</label>
            <input type="date" class="form-control" id="fecha" name="fecha" required>
        </div>
        <div class="form-group">
            <label for="estado">Estado</label>
            <select class="form-control" id="estado" name="estado" required>
                <option value="programada">Programada</option>
                <option value="realizada">Realizada</option>
                <option value="cancelada">Cancelada</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Crear Cirugía</button>
    </form>
</div>
@endsection

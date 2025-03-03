@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Cirugía</h1>
    <form action="{{ route('cirugias.update', $cirugia->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="fecha">Fecha</label>
            <input type="date" class="form-control" id="fecha" name="fecha" value="{{ $cirugia->fecha }}" required>
        </div>
        <div class="form-group">
            <label for="hora">Hora</label>
            <input type="time" class="form-control" id="hora" name="hora" value="{{ $cirugia->hora }}" required>
        </div>
        <div class="form-group">
            <label for="estado">Estado</label>
            <select class="form-control" id="estado" name="estado">
                <option value="pendiente" {{ $cirugia->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="programada" {{ $cirugia->estado == 'programada' ? 'selected' : '' }}>Programada</option>
                <option value="en proceso" {{ $cirugia->estado == 'en proceso' ? 'selected' : '' }}>En Proceso</option>
                <option value="finalizada" {{ $cirugia->estado == 'finalizada' ? 'selected' : '' }}>Finalizada</option>
            </select>
        </div>
        <div class="form-group">
            <label for="observaciones">Observaciones</label>
            <textarea class="form-control" id="observaciones" name="observaciones">{{ $cirugia->observaciones }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>
@endsection

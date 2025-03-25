@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Cirugía</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('modulo.cirugias.update', $cirugia->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="fecha">Fecha</label>
            <input type="date" class="form-control" id="fecha" name="fecha" value="{{ $cirugia->fecha }}" required>
            @error('fecha')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="form-group mb-3">
            <label for="hora">Hora</label>
            <input type="time" class="form-control" id="hora" name="hora" value="{{ $cirugia->hora }}" required>
            @error('hora')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="form-group mb-3">
            <label for="estado">Estado</label>
            <select class="form-control" id="estado" name="estado">
                <option value="pendiente" {{ $cirugia->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="programada" {{ $cirugia->estado == 'programada' ? 'selected' : '' }}>Programada</option>
                <option value="en proceso" {{ $cirugia->estado == 'en proceso' ? 'selected' : '' }}>En Proceso</option>
                <option value="finalizada" {{ $cirugia->estado == 'finalizada' ? 'selected' : '' }}>Finalizada</option>
            </select>
            @error('estado')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="form-group mb-3">
            <label for="observaciones">Observaciones</label>
            <textarea class="form-control" id="observaciones" name="observaciones">{{ $cirugia->observaciones }}</textarea>
            @error('observaciones')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Cirugía</button>
        <a href="{{ route('modulo.cirugias.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection

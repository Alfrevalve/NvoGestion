@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Despacho</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('despacho.update', $despacho->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="pedido_id">Pedido ID</label>
            <input type="number" class="form-control" id="pedido_id" name="pedido_id" value="{{ $despacho->pedido_id }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="estado">Estado</label>
            <input type="text" class="form-control" id="estado" name="estado" value="{{ $despacho->estado }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="fecha_despacho">Fecha de Despacho</label>
            <input type="date" class="form-control" id="fecha_despacho" name="fecha_despacho" value="{{ $despacho->fecha_despacho }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="destinatario">Destinatario</label>
            <input type="text" class="form-control" id="destinatario" name="destinatario" value="{{ $despacho->destinatario }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="direccion">Dirección</label>
            <input type="text" class="form-control" id="direccion" name="direccion" value="{{ $despacho->direccion }}">
        </div>

        <div class="form-group mb-3">
            <label for="observaciones">Observaciones</label>
            <textarea class="form-control" id="observaciones" name="observaciones">{{ $despacho->observaciones }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Despacho</button>
        <a href="{{ route('despacho.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection

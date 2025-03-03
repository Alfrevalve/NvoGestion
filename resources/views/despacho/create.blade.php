@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Agregar Nuevo Despacho</h1>
    <form action="{{ route('despacho.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="pedido_id">Pedido ID</label>
            <input type="number" class="form-control" id="pedido_id" name="pedido_id" required>
        </div>
        <div class="form-group">
            <label for="estado">Estado</label>
            <input type="text" class="form-control" id="estado" name="estado" required>
        </div>
        <div class="form-group">
            <label for="fecha_despacho">Fecha de Despacho</label>
            <input type="date" class="form-control" id="fecha_despacho" name="fecha_despacho" required>
        </div>
        <div class="form-group">
            <label for="destinatario">Destinatario</label>
            <input type="text" class="form-control" id="destinatario" name="destinatario" required>
        </div>
        <div class="form-group">
            <label for="direccion">Dirección</label>
            <input type="text" class="form-control" id="direccion" name="direccion">
        </div>
        <div class="form-group">
            <label for="observaciones">Observaciones</label>
            <textarea class="form-control" id="observaciones" name="observaciones"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>
@endsection

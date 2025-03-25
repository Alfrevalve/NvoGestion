@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Despacho</h1>
    <form action="{{ route('modulo.despacho.update', $despacho->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="articulo_id">Artículo</label>
            <input type="text" class="form-control" id="articulo_id" name="articulo_id" value="{{ $despacho->articulo_id }}" required>
        </div>
        <div class="form-group">
            <label for="cantidad">Cantidad</label>
            <input type="number" class="form-control" id="cantidad" name="cantidad" value="{{ $despacho->cantidad }}" required>
        </div>
        <div class="form-group">
            <label for="destino">Destino</label>
            <input type="text" class="form-control" id="destino" name="destino" value="{{ $despacho->destino }}" required>
        </div>
        <div class="form-group">
            <label for="fecha_despacho">Fecha de Despacho</label>
            <input type="date" class="form-control" id="fecha_despacho" name="fecha_despacho" value="{{ $despacho->fecha_despacho }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar Despacho</button>
    </form>
</div>
@endsection

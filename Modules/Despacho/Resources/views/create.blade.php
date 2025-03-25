@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Registrar Despacho</h1>
    <form action="{{ route('modulo.despacho.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="articulo_id">Artículo</label>
            <input type="text" class="form-control" id="articulo_id" name="articulo_id" required>
        </div>
        <div class="form-group">
            <label for="cantidad">Cantidad</label>
            <input type="number" class="form-control" id="cantidad" name="cantidad" required>
        </div>
        <div class="form-group">
            <label for="destino">Destino</label>
            <input type="text" class="form-control" id="destino" name="destino" required>
        </div>
        <div class="form-group">
            <label for="fecha_despacho">Fecha de Despacho</label>
            <input type="date" class="form-control" id="fecha_despacho" name="fecha_despacho" required>
        </div>
        <button type="submit" class="btn btn-primary">Registrar Despacho</button>
    </form>
</div>
@endsection

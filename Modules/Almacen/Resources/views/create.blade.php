@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Registrar Artículo</h1>
    <form action="{{ route('modulo.almacen.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nombre">Nombre del Artículo</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="form-group">
            <label for="cantidad">Cantidad</label>
            <input type="number" class="form-control" id="cantidad" name="cantidad" required>
        </div>
        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion"></textarea>
        </div>
        <div class="form-group">
            <label for="precio">Precio</label>
            <input type="number" class="form-control" id="precio" name="precio" required>
        </div>
        <button type="submit" class="btn btn-primary">Registrar Artículo</button>
    </form>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Artículo</h1>
    <form action="{{ route('modulo.almacen.update', $articulo->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nombre">Nombre del Artículo</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $articulo->nombre }}" required>
        </div>
        <div class="form-group">
            <label for="cantidad">Cantidad</label>
            <input type="number" class="form-control" id="cantidad" name="cantidad" value="{{ $articulo->cantidad }}" required>
        </div>
        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion">{{ $articulo->descripcion }}</textarea>
        </div>
        <div class="form-group">
            <label for="precio">Precio</label>
            <input type="number" class="form-control" id="precio" name="precio" value="{{ $articulo->precio }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar Artículo</button>
    </form>
</div>
@endsection

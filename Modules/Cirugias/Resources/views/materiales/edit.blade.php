@extends('cirugias::layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Editar Material</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('cirugias.materiales.update', $material) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control @error('nombre') is-invalid @enderror"
                           id="nombre" name="nombre" value="{{ old('nombre', $material->nombre) }}" required>
                    @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="codigo" class="form-label">Código</label>
                    <input type="text" class="form-control @error('codigo') is-invalid @enderror"
                           id="codigo" name="codigo" value="{{ old('codigo', $material->codigo) }}">
                    @error('codigo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control @error('descripcion') is-invalid @enderror"
                              id="descripcion" name="descripcion">{{ old('descripcion', $material->descripcion) }}</textarea>
                    @error('descripcion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="cantidad" class="form-label">Cantidad</label>
                    <input type="number" class="form-control @error('cantidad') is-invalid @enderror"
                           id="cantidad" name="cantidad" value="{{ old('cantidad', $material->cantidad) }}" required min="0">
                    @error('cantidad')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="cantidad_minima" class="form-label">Cantidad Mínima</label>
                    <input type="number" class="form-control @error('cantidad_minima') is-invalid @enderror"
                           id="cantidad_minima" name="cantidad_minima" value="{{ old('cantidad_minima', $material->cantidad_minima) }}" min="0">
                    @error('cantidad_minima')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('cirugias.materiales.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Actualizar Material</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
